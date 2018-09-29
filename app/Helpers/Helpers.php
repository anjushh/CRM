<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Cart;

/**
 * @param $status
 * @param $statusCode
 * @param $message
 * @param array $errors
 * @param array $result
 * @return \Illuminate\Http\JsonResponse
 */
function apiResponse($status, $statusCode, $message, $errors = [], $result = [])
{
    $response = ['success' => $status, 'status' => $statusCode];

    if ($message != "") {
        $response['message'] = $message;
    }

    if (count($errors) > 0) {
        $response['errors'] = $errors;
    }

    if (count($result) > 0) {
        $response['result'] = $result;
    }
    return response()->json($response, $statusCode);
}

/**
 * @param null $path
 * @param null $string
 * @return null
 */
function lang($path = null, $string = null)
{
    $lang = $path;
    if (trim($path) != '' && trim($string) == '') {
        $lang = \Lang::get($path);
    } elseif (trim($path) != '' && trim($string) != '') {
        $lang = \Lang::get($path, ['attribute' => $string]);
    }
    return $lang;
}

//For App
function apiResponseApp($status, $statusCode, $message, $errors = [], $data = [])
{
    $response = ['success' => $status, 'status' => $statusCode];
    
    if ($message != "") {
        $response['message']['success'] = $message;
    }

    if (count($errors) > 0) {
        $response['message']['errors'] = $errors;
    }

    if (count($data) > 0) {
        $response['message']['data'] = $data;
    }
    return response()->json($response);
}


/**
 * @param array $errors
 * @return array
 */
function errorMessages($errors = [])
{
    $error = [];
    foreach($errors->toArray() as $key => $value) {
        foreach($value as $messages) {
            $error[$key] = $messages;
        }
    }
    return $error;
}

function convertToLocal($utcDate, $format = null)
{
    $currentTimezone = getCompanySettings('timezone');
    $dateFormat = ($format != "") ? $format : getCompanySettings('datetime_format');
    if($currentTimezone !='') {
        $date = new \DateTime($utcDate, new DateTimeZone('UTC'));
        $date->setTimezone(new DateTimeZone($currentTimezone));
        return $date->format($dateFormat);
    } else {
        $date = new \DateTime($utcDate, new DateTimeZone('UTC'));
        return $date->format($dateFormat);
    }
}
/**
 * @param string $localDate
 * @param string $format
 * @return bool|string
 */
function convertToUtc($localDate = null, $format = null)
{
    //$currentTimezone = getCompanySettings('timezone');
    //$currentTimezone = 'America/Los_Angeles';
    $currentTimezone = 'UTC';    
    $format = ($format == "") ? 'Y-m-d H:i:s' : $format;
    $localDate = ($localDate == "") ? date('Y-m-d H:i:s') : $localDate;
    $date = new \DateTime($localDate, new DateTimeZone($currentTimezone));
    $date->setTimezone(new DateTimeZone('UTC'));
    return $date->format($format);
}

/**
 * @param bool $withTime
 * @return bool|string
 */
function currentDate($withTime = false)
{
    $date = date('Y-m-d H:i:s');
    if (!$withTime) {
        $date = date('Y-m-d');
    }
    return $date;
}

/**
 * Method is used to convert date to
 * specified format
 *
 * @param string $format
 * @param date $date
 *
 * @return Response|String
 */
function dateFormat($format, $date)
{
    if (trim($date) != '') {
        if (trim($date) == '0000-00-00' || trim($date) == '0000-00-00 00:00') {
            return null;
        } else {
            return date($format, strtotime($date));
        }
    }
    return $date;
}

/**
 * @return bool
 */
function isSystemAdmin()
{
    return (\Auth::user()->id == 1) ? true : false;

}

function isAdmin()
{
    if(\Auth::check()) {
        return (\Auth::user()->user_type == 1) ? true : false;
    }

}

/**
 * @return bool
 */
function isSuperAdmin()
{
    if(\Auth::check()) {
        return (\Auth::user()->user_type == 1) ? true : false;
    }
}

/**
 * @return null
 */
function authUserId()
{
    $id = 1;
    if (\Auth::check()) {
        $id = \Auth::user()->id;
    }

    return $id;
}

/**
 * @return null
 */
function authUserIdNull()
{
    $id = null;
    if (\Auth::check()) {
        $id = \Auth::user()->id;
    }

    return $id;
}

function authUser()
{
    $user = null;
    if (\Auth::check()) {
        $user = \Auth::user();
    }
    return $user;
}

/**
 * @return mixed
 */
function loggedInCompanyId()
{
    $id = 1;
    if (\Auth::check()) {
        $id = \Auth::user()->company_id;
    }
    return $id;
}

/**
 * @param $arr
 * @return mixed
 */
function arrayFilter($arr)
{
    foreach($arr as $key => $value)
    {
        if($value == '' || $value == null)
        {
            unset($arr[$key]);
        }
    }
    return $arr;
}

/**
 * @param $status
 * @param $statusCode
 * @param null $message
 * @param null $url
 * @param array $errors
 * @param array $data
 * @return \Illuminate\Http\JsonResponse
 */
function validationResponse($status, $statusCode, $message = null, $url = null, $errors = [], $data = [])
{
    $response = ['success' => $status, 'status' => $statusCode];

    if ($message != "") {
        $response['message'] = $message;
    }

    if ($url != "") {
        $response['url'] = $url;
    }

    if (count($errors) > 0) {
        $response['errors'] = errorMessages($errors);
    }

    if (count($data) > 0) {
        $response['data'] = $data;
    }
    return response()->json($response, $statusCode);
}

/**
 * @param $value
 * @param string $seprator
 *
 * @return string
 */
function numberFormat($value, $seprator = ',')
{
    return ($value > 0) ? number_format($value, 2, '.', $seprator) : '0.00';
}

/**
 * @param $icon
 * @return mixed
 */
function sortIcon($icon)
{
    $iconArray = [
        '0' => 'fa fa-sort',
        '2' => 'fa fa-sort-up',
        '1' => 'fa fa-sort-down',
    ];

    $icon = sortAction($icon);
    return $iconArray[$icon];
}

/**
 * @param $action
 *
 * @return int
 */
function sortAction($action)
{
    $sortAction = 0;
    if($action != "") {
        if ($action == 0) {
            $sortAction = 1;
        } elseif ($action == 1) {
            $sortAction = 2;
        } else {
            $sortAction = 1;
        }
        //$sortAction = ((int)$action === 0) ? 1 : ((int)$action === 1) ? 2 : 3;
    }
    return $sortAction;
}

/**
 * Method is used to return string in lower, upper or ucfirst.
 *
 * @param string $string
 * @param string $type L -> lower, U -> upper, UC -> upper character first
 * @return Response
 */
function string_manip($string = null, $type = 'L')
{
    switch ($type) {
        case 'U':
            return strtoupper($string);
            break;
        case 'UC':
            return ucfirst($string);
            break;
        case 'UCW':
            return ucwords($string);
            break;
        default:
            return strtolower($string);
            break;
    }
}

/**
 * Method is used to create pagination controls
 *
 * @param int $page
 * @param int $total
 * @param int $perPage
 *
 * @return string
 */
function paginationControls($page, $total, $perPage = 20)
{
    $paginates = '';
    $curPage = $page;
    $page -= 1;
    $previousButton = true;
    $next_btn = true;
    $first_btn = false;
    $last_btn = false;
    $noOfPaginations = ceil($total / $perPage);

    /* ---------------Calculating the starting and ending values for the loop----------------------------------- */
    if ($curPage >= 10) {
        $start_loop = $curPage - 5;
        if ($noOfPaginations > $curPage + 5) {
            $end_loop = $curPage + 5;
        } elseif ($curPage <= $noOfPaginations && $curPage > $noOfPaginations - 9) {
            $start_loop = $noOfPaginations - 9;
            $end_loop = $noOfPaginations;
        } else {
            $end_loop = $noOfPaginations;
        }
    } else {
        $start_loop = 1;
        if ($noOfPaginations > 10)
            $end_loop = 10;
        else
            $end_loop = $noOfPaginations;
    }

    $paginates .= '<div class="col-sm-5 padding0 pull-left custom-martop">' .
        lang('common.jump_to') .
        '<input type="text" class="goto" size="1" />
					<button type="button" id="go_btn" class="small-btn small-btn-primary"> <span class="fa fa-arrow-right"> </span> </button> ' .
        lang('common.pages') . ' ' .  $curPage . ' of <span class="_total">' . $noOfPaginations . '</span> | ' . lang('common.total_records', $total) .
        '</div> <ul class="pagination pagination-sm pull-right custom-martop">';

    // FOR ENABLING THE FIRST BUTTON
    if ($first_btn && $curPage > 1) {
        $paginates .= '<li p="1" class="disabled">
	    					<a href="javascript:void(0);">' .
            lang('common.first')
            . '</a>
	    			   </li>';
    } elseif ($first_btn) {
        $paginates .= '<li p="1" class="disabled">
	    					<a href="javascript:void(0);">' .
            lang('common.first')
            . '</a>
	    			   </li>';
    }

    // FOR ENABLING THE PREVIOUS BUTTON
    if ($previousButton && $curPage > 1) {
        $pre = $curPage - 1;
        $paginates .= '<li p="' . $pre . '" class="_paginate">
	    					<a href="javascript:void(0);" aria-label="Previous">
					        	<span aria-hidden="true">&laquo;</span>
				      		</a>
	    			   </li>';
    } elseif ($previousButton) {
        $paginates .= '<li class="disabled">
	    					<a href="javascript:void(0);" aria-label="Previous">
					        	<span aria-hidden="true">&laquo;</span>
				      		</a>
	    			   </li>';
    }

    for ($i = $start_loop; $i <= $end_loop; $i++) {
        if ($curPage == $i)
            $paginates .= '<li p="' . $i . '" class="active"><a href="javascript:void(0);">' . $i . '</a></li>';
        else
            $paginates .= '<li p="' . $i . '" class="_paginate"><a href="javascript:void(0);">' . $i . '</a></li>';
    }

    // TO ENABLE THE NEXT BUTTON
    if ($next_btn && $curPage < $noOfPaginations) {
        $nex = $curPage + 1;
        $paginates .= '<li p="' . $nex . '" class="_paginate">
	    					<a href="javascript:void(0);" aria-label="Next">
					        	<span aria-hidden="true">&raquo;</span>
					      	</a>
	    			   </li>';
    } elseif ($next_btn) {
        $paginates .= '<li class="disabled">
	    					<a href="javascript:void(0);" aria-label="Next">
					        	<span aria-hidden="true">&raquo;</span>
					      	</a>
	    			   </li>';
    }

    // TO ENABLE THE END BUTTON
    if ($last_btn && $curPage < $noOfPaginations) {
        $paginates .= '<li p="' . $noOfPaginations . '" class="_paginate">
	    					<a href="javascript:void(0);">' .
            lang('common.last')
            . '</a>
	    			   </li>';
    } elseif ($last_btn) {
        $paginates .= '<li p="' . $noOfPaginations . '" class="disabled">
	    					<a href="javascript:void(0);">' .
            lang('common.last')
            . '</a>
			   		   </li>';
    }

    $paginates .= '</ul>';

    return $paginates;
}

/**
 * Trim whitespace from inputs
 *
 * @param Request $request
 * @return bool
 */
function trimInputs()
{
    $inputs = Input::all();
    array_walk_recursive($inputs, function (&$value) {
        $value = trim($value);
    });
    Input::merge($inputs);
    return true;
}

/**
 * @param $index
 * @param $page
 * @param $perPage
 * @return mixed
 */
function pageIndex($index, $page, $perPage)
{
    return (($page - 1) * $perPage) + $index;
}


/**
 * @param $menuRute
 * @return bool
 */
function hasMenuRoute($menuRute)
{
    if (authUser() && authUser()->id == 1) {
        return true;
    } else {
        $permissionResult	= getUserPermission();
        return (in_array($menuRute, $permissionResult)) ? true : false;
    }
}

/**
 * @param $number
 * @return string
 */
function paddingLeft($number)
{
    return str_pad($number, 2, "0", STR_PAD_LEFT);
}

/**
 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
 */
function getNavigation()
{
    $userId   = authUser()->id;
    $result = [];
    $resultData = (new UserPermissions)->getUserPermissions(['user_id'=> $userId], true);
    if($resultData) {
        $result = $resultData->toArray();
    }

    $menuId   = (!empty($result)) ? $result['menu_id'] : '';
    $menuData = (new UserPermissions)->userAllowedPermissions($menuId, ['user_id'=> $userId]);
    $menu     = (new Menu)->prepareNavigation($menuData);
    $menu = (isAdmin()) ? renderMenus() : $menu;

    return view('layouts.user-menu', compact('menu'));
}

/**
 * @return array
 */
function getUserPermission()
{
    $userId = authUser()->id;
    $result = (new UserPermissions)->getUserPermissions(['user_id'=> $userId], true);
    $menuId = (!empty($result)) ? $result['menu_id'] : '';
    $menuData = (new UserPermissions)->userAllowedPermissions($menuId, ['user_id'=> $userId]);
    $routes                  = array_column($menuData, 'dependent_routes', 'route');
    $permissionsKeys         = array_keys($routes);
    $permissionsValues       = array_values($routes);
    $permissions             = array_merge($permissionsKeys, $permissionsValues);
    $permissionsComaSeprate  = implode(',', $permissions);
    $permissionResult        = explode(',', $permissionsComaSeprate);
    return $permissionResult;
}

/**
 * @return array
 */
function getSuperAdminRoutes()
{
    return [
        'company.index',
        'company.create',
        'company.store',
        'company.edit',
        'company.update',
        'company.paginate',
        'company.toggle',
        'company.action',
        'menu.index',
        'menu.create',
        'menu.store',
        'menu.edit',
        'menu.update',
        'menu.paginate',
    ];
}
/**
 * @return null
 */
function financialYearId()
{
    $result = (new FinancialYear)->getActiveFinancialYear();
    if ($result) {
        return $result->id;
    }
    return null;
}

/**
 * Method is used on each and every view to display current financial year
 * @return null
 */
function getActiveFinancialYear()
{
    $result = (new FinancialYear)->getActiveFinancialYear();
    if ($result) {
        return $result->name;
    }
    return null;
}

/**
 * @return array
 * @Author Inderjit Singh
 */
function renderMenus() {
    $menus = (new Menu)->getMenuNavigation(true, true);
    return $menus;
}

/*
 * @return Array
 */
function getQuickMenu() {
    $tree = (new Menu)->getMenuNavigation(true, false);
    if(count($tree) > 0) {
        $quickMenuArr = [];
        foreach ($tree as $firstLevel) {
            if(array_key_exists('child', $firstLevel)) {
                foreach($firstLevel['child'] as $key => $value) {
                    if(array_key_exists('quick_menu', $value)) {
                        array_push($quickMenuArr, $value);
                    }
                    else
                        continue;
                }
            }
        }
    }
    return $quickMenuArr;
}

/**
 * @param null $id
 * @return array|null
 */
function getRequestStatus($id = null)
{
    $status = [
        1 => lang('common.pending'),
        2 => lang('common.partially'),
        3 => lang('common.completed'),
    ];
    if ($id) {
        if (!array_key_exists($id, $status)) {
            return null;
        }
        return $status[$id];
    }
    return $status;
}

function getReportFilterParams()
{
    $arr = [
        '' => '--Select Option--',
        '1' => 'Day-Wise',
        '2' => 'Month-Wise',
        '3' => 'Year-Wise',
    ];
    return $arr;
}

function getReportStatus()
{
    $arr = [
        '' => '--Select Option--',
        'daily' => 'Daily Report',
        'monthly' => 'Monthly Report'
    ];
    return $arr;
}

/**
 * @param int $id
 * @return array
 */
/*function getSamplingRestrictedRoutes()
{

}*/

function getPermittedRoutes($id = 1)
{
    $routes = [
        1 => [
            'products.index',
            'products.create',
            'products.edit',
            'products.update',
            'products.drop',
            'product-group.index',
            'product-group.create',
            'product-group.edit',
            'product-group.update',
            'product-group.drop',
            'unit.index',
            'unit.create',
            'unit.edit',
            'unit.update',
            'unit.drop',
            'qualification.index',
            'qualification.create',
            'qualification.edit',
            'qualification.update',
            'qualification.drop',
            'specialization.index',
            'specialization.create',
            'specialization.edit',
            'specialization.update',
            'specialization.drop',
            'request-sample.detail',
            'allotted-item-delete',
            'request-sample.cancel',
            'request-sample-list',
            'request-sample.paginate',
            'request.allot',
            'edit.allotted-item'
        ],
        2=> [
            'report.attendances',
        ],
        3 => [
            'report.expenses',
        ],
        4 => [
            'report.tours'
        ]
    ];
    return $routes[$id];
}

/**
 * @param null $month
 * @param null $tillCurrentMonth
 * @return array
 */
function getMonths($month = null, $tillCurrentMonth = null)
{
    $months = [
        1	=>	'January',
        2	=>	'February',
        3	=>	'March',
        4	=>	'April',
        5	=>	'May',
        6	=>	'June',
        7	=>	'July',
        8	=>	'August',
        9	=>	'September',
        10	=>	'October',
        11	=>	'October',
        12	=>	'December'
    ];

    if ($month != "") {
        return $months[$month];
    }
    return ['' => '-Select Month-'] + $months;
}

/**
 * @param $start
 * @param $end
 * @return array
 */
function getYear($start, $end)
{
    $years = [];
    for($i =$start; $i <=$end; $i++) {
        $years[$i] = $i;
    }
    return ['' => '-Select Year-'] + $years;

}

/**
 * @param null $reportType
 * @param null $skipDay
 * @return int
 * @internal param $action
 */
function getReportType($reportType = null)
{
    $reportArray = [
        1	=>	'Day',
        2	=>	'Month',
        3	=>	'Year',
    ];

    if ($reportType != "") {
        return $reportArray[$reportType];
    }
    return $reportArray;
}

/**
 * @return mixed
 */
function getCompanyInfo()
{
    $result = (new \App\Models\Company())->getCompanyInfo(loggedInCompanyId());
    return $result;
}

/**
 * @return bool
 */
function disableUserType()
{
    $company = [4];
    return (in_array(loggedInCompanyId(), $company)) ? false : true;
}

/**
 * @param $view
 * @param array $data
 * @param string $filename
 */
function generateExcel($view, $data, $filename = 'file') {
    Excel::create($filename, function($excel) use ($view, $data) {
        $excel->sheet('Sheet', function($sheet) use ($view, $data){
            $sheet->loadView($view, $data);
        });
    })->export('xls');
}

function generateExcelFromArray($filename, $array) {
    Excel::create($filename, function($excel) use($array) {
        $excel->sheet('Sheetname', function($sheet) use($array) {
            $sheet->fromArray($array);
        });
    })->export('xls');
}

/**
 * @param int $company
 */
function getPushFCMToken($company = 1)
{
    if ($company == 4) {
        return \Config::get('constants.FIREBASE_API_KEY_UNIK');
    } else {
        return \Config::get('constants.FIREBASE_API_KEY');
    }
}

/**
 * @param $key
 * @return mixed
 */
function getCompanySettings($key) {
    $companySettings = (new Setting)->getSettingService();
    $result = [
        'datetime_format' =>  ( $companySettings['date_time_format'] != '' ) ? $companySettings['date_time_format']: 'Y-m-d H:i:s',
        'timezone' =>  ($companySettings['timestamp'] != '') ? $companySettings['timestamp']:'Asia/Kolkata',
    ];
    if(array_key_exists($key, $result)) {
        return $result[$key];
    }
}

/**
 * @param null $id
 * @return mixed
 */
function getStatusNameById($id = null) {

    $result = [
        0 => 'Pending',
        1 => 'Approved'
    ];

    if(array_key_exists($id, $result)) {
        return $result[$id];
    }
    return $result[0];
}

/**
 * @param null $id
 * @return mixed
 */
function getVehicleTypeByNumber($id = null) {
    $vehicleTypes = [
        1 => 'Two Wheeler',
        2 => 'Three Wheeler',
        3 => 'Tempo',
        4 => 'Mini Truck',
    ];

    if($id && array_key_exists($id, $vehicleTypes)) {
        return $vehicleTypes[$id];
    }
}

function getAllAccounts()
{
    return (new Account)->getAccountService();
}

function getAccountByAccountGroup($id)
{
    return (new Account)->filterAccountService(['account_group_id' => $id]);
}

function convertToDropDown($data = [])
{
    $result = [];
    foreach($data as $value) {
        $group = '';//(isset($value->account_group)) ? ' ----- ' . $value->account_group : '';
        $result[$value->id] =  $value->name . $group;
    }
    return $result;
}

function getStates(){
    $states = DB::table('state_master')->get([\DB::raw("concat(state_name, ' (', state_digit_code) as name"), 'id']);
    foreach($states as $state) {
        $result[$state->id] = $state->name.')';
    }
    return ['' =>'-Select State-'] + $result;
}


function isDebtorORCreditor($id = null) {
    if($id > 0) {
        return (in_array($id, [32, 33])) ? true : false;
    }
    false;
}

function getUserTypes($type = null) {
    $types = ['' => '', 1 => 'REGISTERED', 2 => 'UN-REGISTERED', 3 => 'COMPOSITE', 4 => 'UIN'];
    if ($type != "") {
        return $types[$type];
    }
    return $types;
}

function getDebtorId() {
    return 33;
}

function getCreditorId() {
    return 32;
}

function transactionByKey($type = null)
{
    $types = ['O' => 1, 'S' => 2, 'P' => 3, 'PV' => 4, 'RV' => 5, 'C' => 6, 'J' => 7];
    if ($type != "") {
        return $types[$type];
    }
    return $types;
}

function paymentMode()
{
    return [
        ''  => '-Select Payment Mode-',
        1   => 'Cash',
        2   => 'Credit',
        3   => 'Online',
    ];
}

function mode()
{
    return [
        1   => 'Cash',
        2   => 'Credit',
    ];
}

function yesNo()
{
    return [
        1   => 'No',
        2   => 'Yes',
    ];
}

function discountType()
{
    return [
        ''  => '-Select Discount Type-',
        1   => 'STD %',
        2   => 'CD %',
    ];
}

function cities()
{
    return (new Cities)->getAreaService();
}

function vehicles()
{
    return (new Vehicle)->getVehicleService();
}

function getPreviousDate() {
    return date('Y-m-d', strtotime(' -1 day'));
}

/**
 * @param null $poID
 * @return bool
 */
function isPoEditable($poID = null)
{
    $result = (new GoodReceiptNote)->getGrnIDByPoId($poID);
    if($result)
    {
        return false;
    }
    return true;
}

/**
 * @param null $id
 * @return bool
 */
function isInitial($id = null)
{
    $result = (new GoodReceiptNote)->where('supplier_order_id', $id)->first();
    if(count($result) > 0)
    {
        return false;
    }
    return true;
}

function saleType()
{
    return [
        1   => 'Local',
        2   => 'Inter-State',
    ];
}

function getStockType($type = null) {
    $typeArray = [
        1	=>	'Receive',
        2	=>	'Damage',
    ];
    if ($type != "") {
        return $typeArray[$type];
    }
    return $typeArray;
}

function addDays($date, $days, $format = 'Y-m-d H:i:s'){
    $date = strtotime('+' . $days . ' days', strtotime($date));
    return date($format, $date);
}

function saleOrderStatus($type = null)
{
    $types = [
        1 => 'Created',
        2 => 'Delivered',
        3 => 'Billed',
        4 => 'Cancel',
    ];

    if ($type != "") {
        return $types[$type];
    }
    return $types;
}

function saleInvoiceStatus($type = null)
{
    $types = [
        1 => 'Created (Unpaid)',
        2 => 'Paid',
        3 => 'Partially Paid',
        4 => 'Cancel',
    ];

    if ($type != "") {
        return $types[$type];
    }
    return $types;
}

function purchaseOrderStatus($type = null)
{
    $types = [
        1 => 'Created (Open)',
        2 => 'Partially Open',
        3 => 'Fully Received (Closed)',
        4 => 'Cancel',
    ];

    if ($type != "") {
        return $types[$type];
    }
    return $types;
}

function purchaseInvoiceStatus($type = null)
{
    $types = [
        1 => 'Paid',
        2 => 'Partially Paid',
        3 => 'Unpaid',
        4 => 'Cancel',
    ];

    if ($type != "") {
        return $types[$type];
    }
    return $types;
}

function grnStatus($type = null) {
    $types = [
        1 => 'Open',
        2 => 'Partially Open',
        3 => 'Closed',
    ];

    if ($type != "") {
        return $types[$type];
    }
    return $types;
}


/**
 * @param null $paymentStatus
 * @param null $skipDay
 * @return int
 * @internal param $action
 */
function getPaymentStatusType($paymentStatus = null)
{
    $paymentArray = [
        1   =>  'Pending',
        2   =>  'Approved',
        3   =>  'Failed',
    ];

    if ($paymentStatus != "") {
        return $paymentArray[$paymentStatus];
    }
    return $paymentArray;
}

/**
 * @param null $paymentStatus
 * @param null $skipDay
 * @return int
 * @internal param $action
 */
function getShopcartItems()
{
    $carts = [];
    $carts = (new Cart)->getCartItems();
    return $carts;
}
