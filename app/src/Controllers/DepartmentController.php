<?php
/**
 * Created by PhpStorm.
 * User: dmitriy
 * Date: 24.11.17
 * Time: 2:15
 */

namespace App\Controllers;

use App\Models\Department;
use App\Models\Site;

class DepartmentController extends Controller
{
    public function readAll($request, $response)
    {
        $departments = Department::all();
        return json_encode($departments);
    }

    public function department($request, $response, $args){

        return $this->container->view->render($response, 'view_department.twig');
    }

    public function readSite($request, $response, $args)
    {
        if ($args['site_id'] <= 0) return 'Неверный id';

        $departments = Department::where('site_id', $args['site_id'])->get();
        return json_encode($departments);
    }

    public function read($request, $response, $args)
    {
        if ($args['id'] <= 0) return 'Неверный id';

        $department = Department::findOrFail($args['id']);
        return json_encode($department);
    }

    public function list($request, $response, $args){
        $role = $this->container->role->getUserRole();
        $user = $this->container->auth->user();
        if (empty($args['id'])) {
            if ($role->role_name === 'admin') {
                return $response->withJson(Department::all());
            }
            else {
                $sites = Site::where('owner_id', $user->id)->get();
                $output = array();
                foreach ($sites as $site) {
                    $departments = Department::where('site_id', $site->id)->get();
                    foreach ($departments as $department) {
                        array_push($output, $department);
                    }
                }
                return $response->withJson($output);
            }

        }
        return $response->withJson(Department::findorFail($args['id']));
    }


    public function getCreate($request, $response)
    {
        return $this->container->view->render($response, 'department.twig');
    }

    public function postCreate($request, $response)
    {
        $department = Department::create([
            'department_id' => $request->getParam('id'),
            'department_name' => $request->getParam('department_name'),
            'description' => $request->getParam('description'),
            'site_id' => $request->getParam('site_id')
        ]);
        return "id: " . (string)$department['department_id'];
    }


    public function update($request, $response, $args)
    {
        if ($args['id'] <= 0) return 'Неверный id';

        $department = Department::findOrFail($args['id']);
        //$department->department_id = $request->getParam('id');
        $department->department_name = $request->getParam('department_name');
        $department->description = $request->getParam('description');
        $department->site_id = $request->getParam('site_id');

        $department->save();
        return (string)$department['department_id'];
    }

    public function delete($request, $response, $args)
    {
        if ($args['id'] <= 0) return 'Неверный id';

        $department = Department::findOrFail($args['id']);
        $department->delete();
        return 'Удаление успешно';
    }
}