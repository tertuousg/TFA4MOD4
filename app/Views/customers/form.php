<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="form-card">
    <p class="eyebrow">Customer account</p>
    <h1><?= esc($title) ?></h1>

    <?php $errors = session()->getFlashdata('errors') ?? []; ?>
    <?php if ($errors): ?>
        <div class="alert error" role="alert">
            <strong>Please correct the following:</strong>
            <ul><?php foreach ($errors as $error): ?><li><?= esc($error) ?></li><?php endforeach; ?></ul>
        </div>
    <?php endif; ?>

    <form action="<?= esc($action) ?>" method="post">
        <?= csrf_field() ?>
        <label for="full_name">Full name <span>*</span></label>
        <input id="full_name" name="full_name" value="<?= esc(old('full_name', $customer['full_name'] ?? '')) ?>" required maxlength="100">

        <label for="email">Email <span>*</span></label>
        <input id="email" type="email" name="email" value="<?= esc(old('email', $customer['email'] ?? '')) ?>" required maxlength="100">

        <label for="phone">Phone</label>
        <input id="phone" name="phone" value="<?= esc(old('phone', $customer['phone'] ?? '')) ?>" maxlength="20">

        <div class="form-actions">
            <button class="button" type="submit">Save Customer</button>
            <a class="button secondary" href="<?= site_url('customers') ?>">Cancel</a>
        </div>
    </form>
</div>

<?= $this->endSection() ?>
