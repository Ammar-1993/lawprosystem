<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Role;
use App\Traits\DatatablTrait;
use Session;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    use DatatablTrait;

    protected $data = [];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        $user = Auth::guard('admin')->user();
        if ($user->user_type == "User") {
            abort(403, 'Unauthorized action.');
        }

        return view('admin.role.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $userType = Auth::guard('admin')->user()->user_type;
        if ($userType != "Admin") {
            abort(403, 'Unauthorized action.');
        }
        return response()->json([
            'html' => view('admin.role.create')->render()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        //dd($request->all());

        $role = new Role();
        $role->slug = $request->slug;
        $role->description = $request->description;
        $role->save();
        return response()->json([
            'success' => true,
            'message' => __('backend.role_created_successfully')
        ], 200);
    }

    public function roleList(Request $request)
    {


        // Listing column to show
        $columns = array(
            0 => 'id',
            1 => 'slug',
            2 => 'action',
        );


        $totalData = Role::where('id', '!=', '1')->count();
        $totalRec = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $search = $request->input('search.value');


        $customcollections = Role::where('id', '!=', '1')
            ->when($search, function ($query, $search) {
                return $query->where('slug', 'LIKE', "%{$search}%");
            });

        $totalFiltered = $customcollections->count();

        $customcollections = $customcollections->offset($start)->limit($limit)->orderBy($order, $dir)->get();

        $data = [];

        foreach ($customcollections as $key => $item) {

            // $row['id'] = $item->id;

            if (empty($request->input('search.value'))) {
                $final = $totalRec - $start;
                $row['id'] = $final;
                $totalRec--;
            } else {
                $start++;
                $row['id'] = $start;
            }

            $row['slug'] = $item->slug;


            $row['action'] = $this->action([
                'delete_permission' => '1',
                'edit_permission' => '1',
                'edit_modal' => collect([
                    'id' => $item->id,
                    'action' => route('role.edit', $item->id),
                    'target' => '#addtag'
                ]),
                'delete' => collect([
                    'id' => $item->id,
                    'action' => route('role.destroy', $item->id),
                ]),
                'permission' => route('permission.edit', $item->id),
            ]);

            $data[] = $row;

        }

        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data,
        );

        return response()->json($json_data);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $data['role_id'] = $id;
        return view('admin.role.permission', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $userType = Auth::guard('admin')->user()->user_type;
        if ($userType != "Admin") {
            abort(403, 'Unauthorized action.');
        }
        $this->data['role'] = Role::findOrFail($id);
        return response()->json([
            'html' => view('admin.role.edit', $this->data)->render()
        ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        // dd($request->all());
        $role = Role::find($id);
        $role->slug = $request->slug;
        $role->description = $request->description;
        $role->save();
        return response()->json([
            'success' => true,
            'message' => __('backend.role_updated_successfully')
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Role::findOrFail($id);

        // if role has no permissions then delete
        if ($role->permissions()->count() > 0) {

            return response()->json([
                'error' => true,
                'message' => __('backend.cannot_delete_role_has_permissions')
            ], 400);
        }
        $role->delete();


        return response()->json([
            'success' => true,
            'message' => __('backend.role_deleted_successfully')
        ], 200);


    }
}
