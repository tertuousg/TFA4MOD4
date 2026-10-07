<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="page-heading">
    <div>
        <p class="eyebrow">Account management</p>
        <h1>Customer Accounts</h1>
    </div>
    <a class="button" href="<?= site_url('customers/new') ?>">New Customer</a>
</div>

<div class="table-wrap">
    <table>
        <thead><tr><th>Full Name</th><th>Email</th><th>Phone</th><th>Action</th></tr></thead>
        <tbody>
        <?php if ($customers === []): ?>
            <tr><td colspan="4" class="empty">No customers found.</td></tr>
        <?php endif; ?>
        <?php foreach ($customers as $customer): ?>
            <tr>
                <td><?= esc($customer['full_name']) ?></td>
                <td><?= esc($customer['email']) ?></td>
                <td><?= esc($customer['phone'] ?: '—') ?></td>
                <td><div class="row-actions"><a class="text-link" href="<?= site_url('customers/' . $customer['id'] . '/edit') ?>">Edit</a><form action="<?= site_url('customers/' . $customer['id'] . '/delete') ?>" method="post" onsubmit="return confirm('Delete this customer?')"><?= csrf_field() ?><button class="danger-link" type="submit">Delete</button></form></div></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>
