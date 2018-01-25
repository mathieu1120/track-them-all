<?php

namespace App\Http\Controllers;

use App\Http\Requests\JoinGroup;
use App\Http\Requests\PostGroups;
use App\Models\Groups;
use App\Models\GroupUserMaps;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GroupController extends Controller
{

    public function getGroup(Request $request, $groupId) {
        /**
         * @var Groups $group
         */
        $group = Groups::find($groupId);
        if (!$group->id) {
            return new JsonResponse(['success' => false], JsonResponse::HTTP_BAD_REQUEST);
        }

        if ($group->isPrivateGroup()
            && $request->user()->id != $group->user_id
            && !$group->isCorrectPassword($request->header('group-password'))) {
            return new JsonResponse([
                'success' => false,
                'message' => 'wrong password'
            ], JsonResponse::HTTP_BAD_REQUEST);
        }

        $groupOwner = User::with('location')->find($group->user->id)->toArray();
        $groupUsers = User::with('location')->whereIn('id', $group->users->pluck('id'))->get()->toArray();
        return new JsonResponse([
            'groupOwner' => $groupOwner,
            'groupUsers' => $groupUsers
        ]);
    }

    public function getGroups(Request $request) {
        /**
         * @var User $user
         */
        $user = $request->user();
        $userGroups = $user->groups->toArray();
        $belongToGroups = $user->isInGroups->toArray();
        return new JsonResponse([
            'userGroups' => $userGroups,
            'belongToGroups' => $belongToGroups
        ]);
    }

    public function postGroups(PostGroups $request) {
        $data = $request->all();
        $data['user_id'] = $request->user()->id;
        return $this->create($data);
    }

    public function joinGroup(JoinGroup $request, $groupId) {
        $data = [];
        $data['name'] = $request->get('name');
        if ($request->get('user_id')) {
            $data['user_id'] = $request->get('user_id');
        }
        $data['active'] = 1;
        $data['id'] = $groupId;
        /**
         * @var Groups $group
         */
        $group = Groups::where($data)->first();
        $password = $request->get('password');
        if ($group->isPrivateGroup() && $password && !$group->isCorrectPassword($password)) {
            return new JsonResponse(['success' => false], JsonResponse::HTTP_BAD_REQUEST);
        }

        return $this->joinCreate([
            'user_id' => $request->user()->id,
            'group_id' => $group->id
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return Groups::create($data);
    }

    protected function joinCreate(array $data) {
        return GroupUserMaps::create($data);
    }

    public function test() {

    }
}
