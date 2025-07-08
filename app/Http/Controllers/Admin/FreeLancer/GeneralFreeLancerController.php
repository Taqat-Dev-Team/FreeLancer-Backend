<?php

namespace App\Http\Controllers\Admin\FreeLancer;

use App\Http\Controllers\Controller;
use App\Mail\AdminMessageToFreelancer;
use App\Models\Badge;
use App\Models\Freelancer;
use App\Models\IdentityVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\DataTables;

class GeneralFreeLancerController extends Controller
{

    public function status(Request $request, $id)
    {
        $freelancer = Freelancer::find($id);

        if (!$freelancer) {
            return response()->json(['message' => 'Freelancer not found.'], 404);
        }

        $user = $freelancer->user;
        $previousStatus = $user->status;
        $user->status = !$user->status;
        $user->save();

        // إرسال الإيميل حسب الحالة الجديدة
        if ($user->status) {
            // تم التفعيل
            Mail::to($user->email)->send(new \App\Mail\FreelancerActivated($user));
        } else {
            // تم التعطيل مع سبب
            $reason = $request->input('reason');
            Mail::to($user->email)->send(new \App\Mail\FreelancerDeactivated($user, $reason));
        }

        return response()->json(['message' => 'Freelancer status updated successfully.']);
    }

    public function ActiveByAdmin($id)
    {
        $freelancer = Freelancer::find($id);
        if (!$freelancer) {
            return response()->json(['message' => 'Freelancer not found.'], 404);
        }

        $freelancer->admin_available_hire = 1;
        Mail::to($freelancer->user->email)->send(new AdminMessageToFreelancer(trans('messages.freelancer_admin_active', [], $freelancer->user->lang ?? 'ar'), $freelancer->user));

        $freelancer->save();

        return response()->json(['message' => 'Freelancer admin availability updated successfully.']);

    }

    public function deactivateByAdmin($id)
    {
        $freelancer = Freelancer::find($id);
        if (!$freelancer) {
            return response()->json(['message' => 'Freelancer not found.'], 404);
        }

        $freelancer->admin_available_hire = 0;
        Mail::to($freelancer->user->email)->send(new AdminMessageToFreelancer(trans('messages.freelancer_admin_deactivate', [], $freelancer->user->lang ?? 'ar'), $freelancer->user));

        $freelancer->save();

        return response()->json(['message' => 'Freelancer admin availability updated successfully.']);

    }

    public function destroy($id)
    {
        return 1;
        $freelancer = Freelancer::find($id);
        $freelancer->delete();
        return response()->json(['message' => 'Freelancer deleted successfully.']);

    }



    public function show($id)
    {
        $freelancer = Freelancer::findOrFail($id);
        $badges = $freelancer->badges;

        $anotherBadges = Badge::whereNotIn('id', $badges->pluck('id'))->get();
        $idHistory = $freelancer->identityVerification()->get();
        return view('admin.FreeLancer.Index.index', compact('freelancer', 'idHistory', 'anotherBadges'));

    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:freelancers,id',
            'message' => 'required|string|max:2000',
        ]);

        $freelancer = Freelancer::with('user')->find($request->id);

        if (!$freelancer || !$freelancer->user || !$freelancer->user->email) {
            return response()->json(['message' => 'Freelancer email not found.'], 404);
        }

        // إرسال البريد
        Mail::to($freelancer->user->email)->send(new AdminMessageToFreelancer($request->message, $freelancer->user));

        return response()->json(['message' => 'Message sent successfully!']);
    }

    public function deleteBadge($freelancerId, $badgeId)
    {
        $freelancer = Freelancer::findOrFail($freelancerId);

        // Check if the badge is actually assigned
        if (!$freelancer->badges()->where('badge_id', $badgeId)->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Badge not found for this freelancer.'
            ], 404);
        }

        // Detach the badge
        $freelancer->badges()->detach($badgeId);

        return response()->json([
            'success' => true,
            'message' => 'Badge deleted successfully.'
        ]);
    }

    public function assignBadge(Request $request)
    {
        $request->validate([
            'freelancer_id' => 'required|exists:freelancers,id',
            'badge_id' => 'required|exists:badges,id',
        ]);

        $freelancer = Freelancer::findOrFail($request->freelancer_id);

        if ($freelancer->badges()->where('badge_id', $request->badge_id)->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'This badge is already assigned to the freelancer.'
            ], 409);
        }

        $freelancer->badges()->attach($request->badge_id);

        return response()->json([
            'success' => true,
            'message' => 'Badge assigned successfully.'
        ]);
    }


}
