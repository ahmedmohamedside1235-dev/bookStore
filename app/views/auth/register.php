<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="<?= asset('shared/styles/css/all.min.css') ?>">
    <link rel="stylesheet" href="<?= asset('shared/styles/css/bootstrap.css') ?>">
    <link rel="stylesheet" href="<?= asset('shared/styles/global/global.css') ?>">
    <link rel="stylesheet" href="<?= asset('auth/register/css/register.css') ?>">

</head>

<body>
    <?php require_once __DIR__ . "/../shared/components/navbar.php" ?>
    <div id="Register" class="py-5">
        <div class="content">
            <form action="<?= route('/auth/register') ?>" method="POST">
                <h2 class="text-center mb-4">Create an account</h2>
                <?= showsessionMsg('correct', false) ?>
                <?= showSessionMsg('invalid') ?>
                <div class="mb-4">
                    <label for="Role" class="form-label">Role :</label>
                    <select name="role" id="Role" class="form-control">
                        <option value="" <?= oldSelected('role', ""); ?> hidden></option>
                        <?= showSelectedOptions() ?>
                    </select>
                    <?= showError('role') ?>
                </div>
                <div class="mb-4">
                    <label for="Name" class="form-label">Name :</label>
                    <input type="text" class="form-control" value="<?= old('name') ?>" name="name" id="Name" placeholder="e.g. Ahmed mohamed">
                    <?= showError('name') ?>
                </div>
                <div class="mb-4">
                    <label for="Email" class="form-label">Email :</label>
                    <input type="text" class="form-control" value="<?= old('email') ?>" name="email" id="Email" placeholder="name@example.com">
                    <?= showError('email') ?>
                </div>
                <div class="mb-4">
                    <label for="Password" class="form-label">Password :</label>
                    <div class="password_icon position-relative">
                        <i class="fa-solid fa-eye" onclick="togglePassword(this)"></i>
                        <input type="password" class="form-control" value="<?= old('password') ?>" name="password" id="Password" placeholder="••••••••">
                    </div>
                    <?= showError('password') ?>
                </div>
                <div class="mb-4">
                    <label for="Phone" class="form-label">Phone :</label>
                    <input type="text" class="form-control" value="<?= old('phone') ?>" name="phone" id="Phone" placeholder="EGPhone">
                    <?= showError('phone') ?>
                </div>

                <div class="mb-4">
                    <label class="form-label me-3 mb-0">Gender :</label>
                    <label class="me-2"><input type="radio" name="gender" value="male" <?= oldSelected('gender', "male", false, true); ?>> Male</label>
                    <label><input type="radio" value="female" name="gender" <?= oldSelected('gender', "female", true, true); ?>> Female</label>
                    <?= showError('gender') ?>
                </div>

                <button class="btn w-100 mb-4">Register</button>
            </form>
            <p class="text-center mb-0">Don't have an account?<a class="ms-2" href="<?= route("/auth/login") ?>">Login</a></p>
        </div>
    </div>

    <script src="<?= asset('shared/script/bootstrap.js') ?>"></script>
    <script src="<?= asset('shared/script/jquery.js') ?>"></script>
    <script src="<?= asset('shared/script/activeNavLinks.js') ?>"></script>


</body>

</html>