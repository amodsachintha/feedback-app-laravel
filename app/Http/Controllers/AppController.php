<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AppController extends Controller
{

    public function __construct()
    {
        if (!Session::has('summary_year')) {
            session(['summary_year' => date('Y')]);
        }
    }


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
                ->select('feedback_service_records.*', 'feedback_services.service')
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
            ->select('feedback_service_records.*', 'feedback_services.service')
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

        return response()->json(['status' => 'ok']);
    }


    public function setResolved(Request $request)
    {
        $nic = $request->get('nic');
        $id = $request->get('service_id');

        DB::table('feedback_service_records')
            ->where('customer_nic', $nic)
            ->where('id', $id)
            ->update([
                'resolved' => true,
                'updated_at' => Carbon::now(),
            ]);

        return response()->json(['status' => 'ok']);
    }

    public function incrementVisit(Request $request)
    {
        $nic = $request->get('nic');
        $id = $request->get('service_id');
        $n = intval($request->get('n')) + 1;

        DB::table('feedback_service_records')
            ->where('customer_nic', $nic)
            ->where('id', $id)
            ->update([
                'n' => $n,
                'updated_at' => Carbon::now(),
            ]);

        return response()->json(['status' => 'ok']);
    }

    public function viewAllUnresolvedCustomers()
    {
        $customers = DB::table('feedback_customers')
            ->join('feedback_service_records', 'feedback_service_records.customer_nic', 'feedback_customers.nic')
            ->where('feedback_service_records.resolved', false)
            ->select(['nic', 'name', 'address', 'mobile', DB::raw('count(customer_nic) as count')])
            ->groupBy('customer_nic')
            ->orderBy('feedback_customers.created_at', 'DESC')
            ->paginate(10);

        return view('all_unresolved', ['customers' => $customers]);
    }

    public function viewAllCustomers()
    {
        $customers = DB::table('feedback_customers')
            ->orderBy('feedback_customers.created_at', 'DESC')
            ->paginate(10);

        return view('all_customers', ['customers' => $customers]);
    }


    public function showSummary(Request $request)
    {
        $year = $request->get('year');
        if ($request->has('month')) {
            $month = $request->get('month');
        } else {
            $month = date('m');
        }

        $months = [];
        if ($year != strval(date('Y'))) {
            for ($i = 1; $i <= 12; $i++)
                array_push($months, strval(date('F', strtotime(date($year . '-' . $i . '-1')))));
        } else {
            for ($i = 1; $i <= intval(date('m')); $i++)
                array_push($months, strval(date('F', strtotime(date($year . '-' . $i . '-1')))));
        }


        $service_ids = DB::table('feedback_service_records')
            ->select(['service_id'])
            ->where('updated_at', '>=', date($year . '-' . intval($month) . '-1'))
            ->where('updated_at', '<=', date($year . '-' . intval($month) . '-31'))
            ->groupBy('service_id')
            ->orderBy('service_id', 'ASC')
            ->get();

        $services = DB::table('feedback_service_records')
            ->join('feedback_services', 'feedback_service_records.service_id', 'feedback_services.id')
            ->select(['feedback_services.id', 'feedback_services.service'])
            ->where('feedback_service_records.updated_at', '>=', date($year . '-' . intval($month) . '-1'))
            ->where('feedback_service_records.updated_at', '<=', date($year . '-' . intval($month) . '-31'))
            ->groupBy('feedback_service_records.service_id')
            ->orderBy('feedback_service_records.service_id', 'ASC')
            ->get();

        $recs = array();

        foreach ($service_ids as $ids) {
            $custs = DB::table('feedback_customers')
                ->join('feedback_service_records', 'feedback_service_records.customer_nic', 'feedback_customers.nic')
                ->select(['name', 'nic', 'mobile', 'date_time', 'feedback_service_records.updated_at', 'resolved', 'n'])
                ->where('feedback_service_records.updated_at', '>=', date($year . '-' . intval($month) . '-1'))
                ->where('feedback_service_records.updated_at', '<=', date($year . '-' . intval($month) . '-31'))
                ->where('feedback_service_records.service_id', $ids->service_id)
                ->orderBy('feedback_service_records.updated_at', 'DESC')
                ->get();

            array_push($recs, [$ids->service_id => $custs]);

        }

        return view('summary')->with([
            'months' => $months,
            'month' => $month,
            'services' => $services,
            'recs' => $recs

        ]);
    }

    public function showSummaryAll(Request $request)
    {
        $year = $request->get('year');
        $months = [];
        if ($year != strval(date('Y'))) {
            for ($i = 1; $i <= 12; $i++)
                array_push($months, strval(date('F', strtotime(date($year . '-' . $i . '-1')))));
        } else {
            for ($i = 1; $i <= intval(date('m')); $i++)
                array_push($months, strval(date('F', strtotime(date($year . '-' . $i . '-1')))));
        }

        $service_ids = DB::table('feedback_service_records')
            ->select(['service_id'])
            ->where('updated_at', '>=', date($year . '-1-1'))
            ->where('updated_at', '<=', date($year . '-12-31'))
            ->groupBy('service_id')
            ->orderBy('service_id', 'ASC')
            ->get();

        $services = DB::table('feedback_service_records')
            ->join('feedback_services', 'feedback_service_records.service_id', 'feedback_services.id')
            ->select(['feedback_services.id', 'feedback_services.service'])
            ->where('feedback_service_records.updated_at', '>=', date($year . '-1-1'))
            ->where('feedback_service_records.updated_at', '<=', date($year . '-12-31'))
            ->groupBy('feedback_service_records.service_id')
            ->orderBy('feedback_service_records.service_id', 'ASC')
            ->get();

        $recs = array();

        foreach ($service_ids as $ids) {
            $custs = DB::table('feedback_customers')
                ->join('feedback_service_records', 'feedback_service_records.customer_nic', 'feedback_customers.nic')
                ->select(['name', 'nic', 'mobile', 'date_time', 'feedback_service_records.updated_at', 'resolved', 'n'])
                ->where('feedback_service_records.updated_at', '>=', date($year . '-1-1'))
                ->where('feedback_service_records.updated_at', '<=', date($year . '-12-31'))
                ->where('feedback_service_records.service_id', $ids->service_id)
                ->orderBy('feedback_service_records.updated_at', 'DESC')
                ->get();

            array_push($recs, [$ids->service_id => $custs]);

        }

        return view('summary')->with([
            'months' => $months,
            'services' => $services,
            'recs' => $recs
        ]);
    }


    public function showCustomerServiceHistory(Request $request)
    {
        if ($request->has('nic')) {
            $nic = $request->get('nic');

            $customer = DB::table('feedback_customers')
                ->where('nic', $nic)
                ->first();

            $services = DB::table('feedback_service_records')
                ->join('feedback_services', 'feedback_service_records.service_id', 'feedback_services.id')
                ->select(['service', 'n', 'feedback_service_records.updated_at', 'resolved'])
                ->where('customer_nic', $nic)
                ->orderBy('updated_at', 'DESC')
                ->get();

            return view('cust_services')->with([
                'customer' => $customer,
                'services' => $services,
            ]);

        }

        return response()->json(null, 500);

    }


    public function setYearInSession(Request $request)
    {
        session(['summary_year' => $request->get('year')]);
        return redirect('/view/all?year=' . \session('summary_year'));
    }


}
