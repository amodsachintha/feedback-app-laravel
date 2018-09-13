<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AppController extends Controller
{
    public function checkID(Request $request)
    {
        $nic = $request->get('nic');
        if ($nic == "" || $nic == null) {
            return back();
        }

        $nic = strtolower($nic);

        $cust_count = DB::table('feedback_customers')
            ->where('nic', $nic)
            ->count();

        $services = DB::table('feedback_services')
            ->get();

        if ($cust_count == 0) {

            return view('register_id', ['nic' => $nic, 'services' => $services]);
        } else {
            $cust = DB::table('feedback_customers')
                ->where('nic', $nic)
                ->first();

            $services_pending = DB::table('feedback_service_records')
                ->join('feedback_services', 'feedback_service_records.service_id', 'feedback_services.id')
                ->select('feedback_service_records.*','feedback_services.service')
                ->where('feedback_service_records.customer_nic', $nic)
                ->where('feedback_service_records.resolved', false)
                ->get();

            return view('cust_dash', ['customer' => $cust, 'pending' => $services_pending, 'services' => $services]);
        }


    }


    public function addCustomer(Request $request)
    {
        $nic = strtolower($request->get('nic'));
        $name = $request->get('name');
        $mobile = $request->get('mobile');
        $address = $request->get('address');
        $service_id = $request->get('service_id');
        $service_des = $request->get('service_des');

        DB::table('feedback_customers')
            ->insert([
                'nic' => $nic,
                'name' => $name,
                'address' => $address,
                'mobile' => $mobile,
                'updated_at' => Carbon::now(),
                'created_at' => Carbon::now(),
            ]);

        DB::table('feedback_service_records')
            ->insert([
                'customer_nic' => $nic,
                'service_id' => $service_id,
                'description' => $service_des,
                'date_time' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'created_at' => Carbon::now(),
            ]);

        $services = DB::table('feedback_services')
            ->get();

        $cust = DB::table('feedback_customers')
            ->where('nic', $nic)
            ->first();

        $services_pending = DB::table('feedback_service_records')
            ->join('feedback_services', 'feedback_service_records.service_id', 'feedback_services.id')
            ->select('feedback_service_records.*','feedback_services.service')
            ->where('feedback_service_records.customer_nic', $nic)
            ->where('feedback_service_records.resolved', false)
            ->get();

        return view('cust_dash', ['customer' => $cust, 'pending' => $services_pending, 'services' => $services]);
    }


    public function addServiceRecord(Request $request)
    {
        $nic = strtolower($request->get('nic'));
        $service_id = $request->get('service_id');
        $des = $request->get('service_des');

        DB::table('feedback_service_records')
            ->insert([
                'customer_nic' => $nic,
                'service_id' => $service_id,
                'description' => $des,
                'date_time' => Carbon::now(),
                'resolved' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

        return response()->json(['status'=>'ok']);
    }


    public function setResolved(Request $request)
    {
        $nic = $request->get('nic');
        $service_id = $request->get('service_id');

        DB::table('feedback_service_records')
            ->where('customer_nic', $nic)
            ->where('service_id', $service_id)
            ->update([
                'resolved' => true,
                'updated_at' => Carbon::now(),
            ]);

        return response()->json(['status' => 'ok']);
    }

    public function incrementVisit(Request $request)
    {
        $nic = $request->get('nic');
        $service_id = $request->get('service_id');
        $n = intval($request->get('n')) + 1;

        DB::table('feedback_service_records')
            ->where('customer_nic', $nic)
            ->where('service_id', $service_id)
            ->update([
                'n' => $n,
                'updated_at' => Carbon::now(),
            ]);

        return response()->json(['status' => 'ok']);
    }

    public function viewAllUnresolvedCustomers(){
        $customers = DB::table('feedback_customers')
                    ->join('feedback_service_records','feedback_service_records.customer_nic','feedback_customers.nic')
                    ->where('feedback_service_records.resolved',false)
                    ->select(['nic','name','address','mobile',DB::raw('count(customer_nic) as count')])
                    ->groupBy('customer_nic')
                    ->orderBy('feedback_customers.created_at','DESC')
                    ->paginate(10);

        return view('all_unresolved',['customers'=>$customers]);
    }

    public function viewAllCustomers(){
        $customers = DB::table('feedback_customers')
            ->orderBy('feedback_customers.created_at','DESC')
            ->paginate(10);

        return view('all_customers',['customers'=>$customers]);
    }


}
