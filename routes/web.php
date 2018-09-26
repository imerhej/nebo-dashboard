<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
use App\User;
use App\Project;
use App\PunchHour;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();


Route::prefix('workcenter')->middleware('role:superadministrator|administrator|office-manager|manager|supervisor|installer|employee|client')->group(function () {
    Route::get('/', 'WorkCenterController@index');
    Route::get('/workcenter', 'WorkCenterController@workcenter')->name('workcenter.workcenter');
    Route::resource('/users', 'UserController');
    Route::resource('/permissions', 'PermissionController', ['except' => 'destroy']);
    Route::resource('/roles', 'RoleController', ['except' => 'destroy']);
    Route::resource('/projects', 'ProjectController');
    Route::resource('/categories', 'CategoryController');
    Route::resource('/inventory', 'InventoryController');
    Route::resource('/rates', 'RateController');
    Route::resource('/clients', 'ClientController');
    
    Route::get('/schedule/index', 'ScheduleController@schedule')->name('schedule.index');
    Route::post('/schedule/index', 'ScheduleController@storeSchedule')->name('schedule.index');
    Route::delete('/schedule/index/{id}', 'ScheduleController@destorySchedule')->name('schedule.destorySchedule');

    Route::post('/inventory/schedule/{id}', 'InventoryController@scheduleEquipment')->name('inventory.schedule');
    Route::delete('/inventory/schedule/{id}', 'InventoryController@destroyScheduledEquipment');
    Route::get('/inventory/schedule/{id}', 'InventoryController@showScheduledEquipment')->name('inventory.schedule');

    Route::post('/projects/tco/{id}', 'ProjectController@storeTCO')->name('projects.tco');
    Route::delete('/projects/tco/{id}', 'ProjectController@destroyTco');
    
    Route::get('/hrmanagement/reports/{id}', 'ReportController@reports')->name('hrmanagement.reports');
    Route::post('/hrmanagement/reports/{id}', 'ReportController@storeReport')->name('hrmanagement.reports');
    Route::get('/hrmanagement/viewreport/{id}', 'ReportController@viewreport')->name('hrmanagement.viewreport');
    Route::get('/hrmanagement/editreport/{id}', 'ReportController@editreport')->name('hrmanagement.editreport');
    Route::put('/hrmanagement/editreport/{id}', 'ReportController@updatereport');
    Route::delete('/hrmanagement/reports/{id}', 'ReportController@destroyReport');

    Route::post('/projects/{id}', 'ChangeOrderController@sendChangeOrder');
    Route::get('/projects/changeOrders/{id}', 'ChangeOrderController@getChangeOrders')->name('projects.changeOrders');
    Route::get('/projects/viewChangeOrder/{id}', 'ChangeOrderController@viewChangeOrder')->name('projects.viewChangeOrder');
    Route::get('/projects/editChangeOrder/{id}', 'ChangeOrderController@editChangeOrder')->name('projects.editChangeOrder');
    Route::put('/projects/editChangeOrder/{id}', 'ChangeOrderController@updateChangeOrder');
    Route::delete('/projects/changeOrders/{id}', 'ChangeOrderController@destroyChangeOrder');

    Route::get('attendance/export','AttendanceController@attendanceExport')->name('attendance.export');
    Route::get('attendance/exportsearch','AttendanceController@exportsearch')->name('attendance.exportsearch');
    Route::get('attendance/singleexport/{id}','AttendanceController@singleexport')->name('attendance.singleexport');
    

    Route::get('/clients/myaccount/{id}', 'ClientController@myaccount')->name('clients.myaccount');
    Route::get('/clients/editaccount/{id}', 'ClientController@geteditaccount')->name('clients.editaccount');
    Route::put('/clients/editaccount/{id}', 'ClientController@updateAccount');
    Route::get('/clients/myproject/{id}', 'ClientProjectController@listMyProjects')->name('clients.myproject');
    Route::get('/clients/viewmyproject/{id}', 'ClientProjectController@getMyProject')->name('clients.viewmyproject');
    Route::get('/clients/viewChangeOrder/{id}', 'ClientProjectController@viewChangeOrder')->name('clients.viewChangeOrder');
    Route::put('/clients/viewChangeOrder/{id}', 'ClientProjectController@updateChangeOrder');

    Route::get('/projects/tasklists/{id}', 'ProjectController@getTasklists')->name('projects.tasklists');
    Route::post('/projects/addTasklist/{id}', 'ProjectController@addTasklist')->name('projects.addTasklist');
    Route::post('/projects/tasklists/{id}', 'ProjectController@storeTaskHoursBySupervisor')->name('projects.storeTaskHoursBySupervisor');
    
    Route::get('/projects/editTasklist/{id}', 'ProjectController@getEditTasklist')->name('projects.editTasklist');
    Route::get('/projects/showTask/{id}', 'ProjectController@showTask')->name('projects.showTask');
    Route::put('/projects/editTasklist/{id}', 'ProjectController@updateTasklist');
    Route::put('/projects/tasklists/{id}', 'ProjectController@updateTask')->name('projects.tasklists');
    Route::delete('/projects/tasklists/{id}', 'ProjectController@destroyTasklist');

    Route::get('/projects/projectbudget/{id}', 'ProjectController@getProjectbudget')->name('projects.projectbudget');
    Route::post('/projects/projectbudget/{id}', 'ProjectController@inputRates');
    // Route::get('/projects/updateprojectrates/{id}', 'ProjectController@getUpdateProjectRates')->name('projects.updateprojectrates');
    // Route::put('/projects/updateprojectrates/{id}', 'ProjectController@updatePorjectRates');
    Route::put('/projects/projectbudget/{id}', 'ProjectController@updateProjectRates');

    Route::get('/projects/tasklistfiles/{id}', 'ProjectController@getTasklistFiles')->name('projects.tasklistfiles');
    Route::post('/projects/tasklistfiles/{id}', 'ProjectController@uploadTaskFiles');
    Route::delete('/projects/tasklistfiles/{id}', 'ProjectController@destroyTaskFile');

    Route::get('/projects/milestones/{id}', 'ProjectController@getMilestones')->name('projects.milestones');
    Route::post('/projects/milestones/{id}', 'ProjectController@addMilestone');
    Route::get('/projects/editMilestone/{id}', 'ProjectController@getEditMilestone')->name('projects.editMilestone');
    Route::put('/projects/editMilestone/{id}', 'ProjectController@updateMilestone');
    Route::delete('/projects/milestones/{id}', 'ProjectController@destroyMilestone');

    Route::get('/projects/files/{id}', 'ProjectController@getFiles')->name('projects.files');
    Route::post('/projects/files/{id}' , 'ProjectController@uploadFile');
    Route::delete('/projects/files/{id}', 'ProjectController@destroyFile');

    Route::get('/projects/rates/{id}', 'ProjectController@getRates')->name('projects.rates');
    Route::get('/projects/editrates/{id}', 'ProjectController@editRates')->name('projects.editrates');
    Route::post('/projects/rates/{id}', 'ProjectController@storeRates');
    Route::put('/projects/editrates/{id}', 'ProjectController@updateRates');

    Route::get('/projects/punchhours/{id}', 'ProjectController@getPunchHours')->name('projects.punchhours');
    Route::post('/projects/punchhours/{id}', 'ProjectController@storeProjectHours');
    Route::get('/projects/punchtaskhours/{id}', 'ProjectController@getPunchTaskHours')->name('projects.punchtaskhours');
    Route::post('/projects/punchtaskhours/{id}', 'ProjectController@storeTaskHours');   

    Route::get('/projects/discussions/{id}', 'ProjectController@getDiscussions')->name('projects.discussions');
    Route::post('/projects/discussions/{id}', 'ProjectController@postDiscussion');
    Route::get('/projects/editDiscussion/{id}', 'ProjectController@getEditDiscussion')->name('projects.editDiscussion');
    Route::put('/projects/editDiscussion/{id}', 'ProjectController@updateDiscussion');
    Route::delete('/projects/discussions/{id}', 'ProjectController@destroyDiscussion');

    Route::get('/hrmanagement', 'HRManagementController@index')->name('hrmanagement.index');
    Route::get('/hrmanagement/departments', 'HRManagementController@getDepartments')->name('hrmanagement.departments');
    Route::get('/hrmanagement/editDepartment/{id}', 'HRManagementController@editDepartment')->name('hrmanagement.editDepartment');
    Route::post('/hrmanagement/updateDepartment/{id}', 'HRManagementController@updateDepartment')->name('hrmanagement.updateDepartment');
    Route::post('/hrmanagement/departments', 'HRManagementController@addDepartment');
    Route::delete('/hrmanagement/departments/{id}', 'HRManagementController@destroyDepartment')->name('hrmanagement.destroyDepartment');
    Route::get('/hrmanagement/employees', 'HRManagementController@getEmployees')->name('hrmanagement.employees');
    Route::get('/hrmanagement/performance/{id}', 'HRManagementController@performance')->name('hrmanagement.performance');
    Route::get('/hrmanagement/createperformance/{id}', 'HRManagementController@createperformance')->name('hrmanagement.createperformance');
    Route::post('/hrmanagement/createperformance/{id}', 'HRManagementController@storeperformance');
    Route::get('/hrmanagement/viewperformance/{id}', 'HRManagementController@viewperformance')->name('hrmanagement.viewperformance');
    Route::get('/hrmanagement/editperformance/{id}', 'HRManagementController@editperformance')->name('hrmanagement.editperformance');
    Route::put('/hrmanagement/editperformance/{id}', 'HRManagementController@updateperformance');
    Route::delete('/hrmanagement/performance/{id}', 'HRManagementController@destroyperformance');

    Route::get('/hrmanagement/availability', 'HRManagementController@getAvailability')->name('hrmanagement.availability');

    Route::get('/calendar', 'CalendarController@index')->name('calendar.index');
    Route::get('/rto/calendar', 'CalendarController@rtoCalendar')->name('rto.calendar');
    
    Route::get('/attendance', 'AttendanceController@index')->name('attendance.index');
    Route::get('/attendance/show/{id}', 'AttendanceController@show')->name('attendance.show');
    Route::get('/attendance/edit/{id}', 'AttendanceController@edit')->name('attendance.edit');
    Route::put('/attendance/edit/{id}', 'AttendanceController@update');
    Route::get('/attendance/search')->name('attendance.search');
    Route::delete('/attendance/show/{id}', 'AttendanceController@destroy')->name('attendance.show');
    Route::get('/attendance/totalHrs/{id}', 'AttendanceController@totalHrs')->name('attendance.totalHrs');

    Route::resource('/notifications', 'NotificationController');
    Route::resource('/messages', 'MessageController');

    Route::resource('/rto', 'LeaveController');
        
    Route::resource('/myaccount', 'MyAccountController');
    Route::get('/myaccount/avatar/{id}', 'MyAccountController@getAvatar')->name('myaccount.avatar');
    Route::get('/myaccount/mytasks/{id}', 'MyAccountController@getMyTasks')->name('myaccount.mytasks');
    Route::post('/myaccount/avatar/{id}', 'MyAccountController@storeAvatar');
    Route::get('/myaccount/myperformance/{id}', 'MyAccountController@myperformance')->name('myaccount.myperformance');
    Route::get('/myaccount/viewperformance/{id}', 'MyAccountController@viewperformance')->name('myaccount.viewperformance');
    Route::get('/myaccount/editperformance/{id}', 'MyAccountController@editperformance')->name('myaccount.editperformance');
    Route::put('/myaccount/editperformance/{id}', 'MyAccountController@updateperformance');
    
    Route::get('/search', 'SearchController@index')->name('search.index');
    
    Route::any('/attendance/search', function(Request $request) {
            $start = $request->start;
            $end = $request->end;

            if (!empty($start) || !empty($end)) {


                $punchhours = DB::table('punch_hours')
                            ->select(DB::raw('punch_hours.user_id, SUM(TIME_TO_SEC(TIMEDIFF(travelOut, travelIn))) as travel_hours,
                                   SUM(TIME_TO_SEC(TIMEDIFF(installOut, installIn))) as work_hours, punch_hours.project_id, users.firstName, users.lastName, projects.projectName'))
                            ->join('users', 'punch_hours.user_id', '=', 'users.id')
                            ->join('projects', 'punch_hours.project_id', '=', 'projects.id')
                            
                            
                            ->whereBetween('travelIn', [$start, $end])
                            ->groupBy('punch_hours.user_id', 'punch_hours.project_id', 'users.firstName', 'users.lastName', 'projects.projectName')
                            ->get()
                            ->toArray();
                
                            // dd($punchhours);
                return view('workcenter.attendance.search')
                            ->withPunchhours($punchhours)
                            ->withStart($start)
                            ->withEnd($end);
            } elseif(empty($start) && empty($end)) {
                return view ('workcenter.attendance.search')->withMessage('No Details found. Try to search again !');
            }
            
        });

        Route::any('/search',function(Request $request){
            $query = $request->search;
            
            if (!empty($query)) {
                $project = Project::where('projectName','LIKE','%'.$query.'%')
                    ->orWhere('projectNumber','LIKE','%'.$query.'%')
                    ->orWhere('quoteNumber','LIKE','%'.$query.'%')
                    ->orWhere('orderNumber','LIKE','%'.$query.'%')
                    ->orWhere('description','LIKE','%'.$query.'%')
                    ->get();
  
                return view('workcenter.search.index')
                        ->withProjects($project)
                        ->withQuery($query);
            } elseif(empty($query)) {
                return view ('workcenter.search.index')->withMessage('No Details found. Try to search again !');
            }
            });            

        // Route::get('/myaccount/timesheet', 'MyAccountController@getTimeSheet')->name('myaccount.timesheet');
  });


// Route::get('/home', 'HomeController@index')->name('home');
