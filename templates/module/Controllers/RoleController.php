<?php namespace $NAME$\User\Controllers;

use $NAME$\ActionLog\Models\ActionLog;
use $NAME$\ActionLog\Repositories\ActionLogRepository;
use $NAME$\User\Repositories\RoleRepository;
use $NAME$\User\Requests\CreateRoleRequest;
use $NAME$\User\Requests\UpdateRoleRequest;
use App\Http\Requests\IndexRequest;
use App\Http\Requests\ShowRequest;
use Illuminate\Http\JsonResponse;
use zgldh\Scaffold\AppBaseController;

class RoleController extends AppBaseController
{

    public function __construct(RoleRepository $roleRepo)
    {
        $this->repository = $roleRepo;
        $this->middleware("auth");
    }

    /**
     * Display a listing of the Role.
     *
     * @param IndexRequest $request
     * @return Response
     */
    public function index(IndexRequest $request)
    {
        $with = $request->getWith();
        $data = $this->repository->datatables(null, $with);

        ActionLogRepository::log(ActionLog::TYPE_SEARCH, 'role');

        return $data;
    }

    /**
     * Store a newly created Role in storage.
     *
     * @param CreateRoleRequest $request
     * @return JsonResponse
     */
    public function store(CreateRoleRequest $request)
    {
        $input = $request->all();

        $role = $this->repository->create($input);
        $role->load($request->getWith());

        ActionLogRepository::log(ActionLog::TYPE_CREATE, 'role');

        return $this->sendResponse($role, 'Role saved successfully.');
    }

    /**
     * Display the specified Role.
     *
     * @param  int $id
     *
     * @return JsonResponse
     */
    public function show($id, ShowRequest $request)
    {
        $role = $this->repository->findWithoutFail($id);
        $role->load($request->getWith());

        if (empty($role)) {
            return $this->sendError('Role not found');
        }

        ActionLogRepository::log(ActionLog::TYPE_SHOW, 'role');

        return $this->sendResponse($role, '');
    }

    /**
     * Update the specified Role in storage.
     *
     * @param  int $id
     * @param UpdateRoleRequest $request
     *
     * @return JsonResponse
     */
    public function update($id, UpdateRoleRequest $request)
    {
        $role = $this->repository->findWithoutFail($id);

        if (empty($role)) {
            return $this->sendError('Role not found');
        }

        $role = $this->repository->update($request->all(), $id);
        $role->load($request->getWith());

        ActionLogRepository::log(ActionLog::TYPE_UPDATE, 'role');

        return $this->sendResponse($role, 'Role updated successfully.');
    }

    /**
     * Remove the specified Role from storage.
     *
     * @param  int $id
     *
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $role = $this->repository->findWithoutFail($id);

        if (empty($role)) {
            return $this->sendError('Role not found');
        }

        $this->repository->delete($id);

        ActionLogRepository::log(ActionLog::TYPE_DELETE, 'role');

        return $this->sendResponse($role, 'Role deleted successfully.');
    }
}
