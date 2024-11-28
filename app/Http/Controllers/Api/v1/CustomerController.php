<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Customer;
use App\Http\Requests\v1\StoreCustomerRequest;
use App\Http\Requests\v1\UpdateCustomerRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\v1\CustomerResource;
use App\Http\Resources\v1\CustomerCollection;
use Illuminate\Http\Request;
use App\Filters\v1\CustomersFilter;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    // public function index() --> for no filtering
    public function index(Request $request) // for filtering
    {
        $filter = new CustomersFilter();
        $filterItems = $filter->transform($request); // [['column', 'operator', 'value']]

        $includeInvoices = $request->query('includeInvoices');

        $customers  = Customer::where($filterItems);
        if ($includeInvoices) {
            $customers = $customers->with('invoices');
        }
        return new CustomerCollection($customers->paginate()->appends($request->query()));

        // return Customer::all();
        // return new CustomerCollection(Customer::all());
        // return new CustomerCollection(Customer::paginate());

        // return new CustomerCollection(Customer::where($filterItems)->paginate());

        // $customers = Customer::where($filterItems)->paginate();
        // return new CustomerCollection($customers->appends($request->query()));
    }

    // MAY BE DELETED
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCustomerRequest $request)
    {
        return new CustomerResource(Customer::create($request->all()));
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        $includeInvoices = request()->query('includeInvoices');
        if ($includeInvoices) {
            return new CustomerResource($customer->loadMissing('invoices'));
        }
        // return $customer;
        return new CustomerResource($customer);
    }

    // MAY BE DELETED
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        $customer->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        //
    }
}
