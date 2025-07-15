<?php

namespace App\Http\Controllers\Admin\FreeLancer;

use App\Http\Controllers\Controller;
use App\Mail\AdminMessageToUser;
use App\Mail\UserActivated;
use App\Mail\FreelancerApprove;
use App\Mail\UserDeactivated;
use App\Mail\FreelancerReject;
use App\Models\Badge;
use App\Models\Freelancer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class GeneralFreeLancerController extends Controller
{

    public function status(Request $request, $id)
    {
        $freelancer = Freelancer::find($id);

        if (!$freelancer) {
            return response()->json(['message' => 'Freelancer not found.'], 404);
        }

        $user = $freelancer->user;
        $user->status = !$user->status;
        $user->save();

        // إرسال الإيميل حسب الحالة الجديدة
        if ($user->status) {
            // تم التفعيل
            Mail::to($user->email)->send(new UserActivated($user));
        } else {
            // تم التعطيل مع سبب
            $reason = $request->input('reason');
            Mail::to($user->email)->send(new UserDeactivated($user, $reason));
        }

        return response()->json(['message' => 'Freelancer status updated successfully.']);
    }


    public function destroy($id)
    {

        $freelancer = Freelancer::find($id);

        $freelancer->user->delete();
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
        Mail::to($freelancer->user->email)->send(new AdminMessageToUser($request->message, $freelancer->user));

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

    public function reviewFreelancer(Request $request, $id)
    {
        $freelancer = Freelancer::findOrFail($id);

        $request->validate([
            'action' => 'required|in:0,1,2', // validate as string
            'reason' => 'nullable|string|max:1000',
        ]);

        $freelancer->review = (string)$request->action;
        $freelancer->review_reason = $request->action === '2' ? $request->reason : null;
        $freelancer->save();

        $message = $request->action === '1' ? 'Freelancer approved successfully.' : 'Freelancer rejected with reason.';

        if ($request->action === '1') {
            Mail::to($freelancer->user->email)->send(new FreelancerApprove($freelancer->user));
        } else {
            Mail::to($freelancer->user->email)->send(new FreelancerReject($freelancer->user, $request->reason));
        }

        return response()->json(['message' => $message]);
    }


}
