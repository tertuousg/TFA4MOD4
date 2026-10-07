<?php

namespace App\Controllers;

use App\Models\CustomerModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Customers extends BaseController
{
    public function index()
    {
        return view('customers/index', [
            'title' => 'Customer Accounts',
            'customers' => (new CustomerModel())->orderBy('full_name')->findAll(),
        ]);
    }

    public function new()
    {
        return view('customers/form', [
            'title' => 'New Customer',
            'customer' => null,
            'action' => site_url('customers'),
        ]);
    }

    public function create()
    {
        $rules = [
            'full_name' => 'required|max_length[100]',
            'email' => 'required|valid_email|max_length[100]',
            'phone' => 'permit_empty|max_length[20]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        (new CustomerModel())->insert($this->customerData());

        return redirect()->to('/customers')->with('success', 'Customer added successfully.');
    }

    public function edit(int $id)
    {
        $customer = (new CustomerModel())->find($id);
        if ($customer === null) {
            throw PageNotFoundException::forPageNotFound('Customer not found.');
        }

        return view('customers/form', [
            'title' => 'Edit Customer',
            'customer' => $customer,
            'action' => site_url('customers/' . $id),
        ]);
    }

    public function update(int $id)
    {
        $model = new CustomerModel();
        if ($model->find($id) === null) {
            throw PageNotFoundException::forPageNotFound('Customer not found.');
        }

        $rules = [
            'full_name' => 'required|max_length[100]',
            'email' => 'required|valid_email|max_length[100]',
            'phone' => 'permit_empty|max_length[20]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $model->update($id, $this->customerData());

        return redirect()->to('/customers')->with('success', 'Customer updated successfully.');
    }

    public function delete(int $id)
    {
        $model = new CustomerModel();
        if ($model->find($id) === null) throw PageNotFoundException::forPageNotFound('Customer not found.');
        $model->delete($id);
        return redirect()->to('/customers')->with('success', 'Customer deleted successfully.');
    }

    private function customerData(): array
    {
        return [
            'full_name' => trim((string) $this->request->getPost('full_name')),
            'email' => trim((string) $this->request->getPost('email')),
            'phone' => trim((string) $this->request->getPost('phone')),
        ];
    }
}
