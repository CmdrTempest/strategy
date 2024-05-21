<?php
/*
Template Name: My Account
*/
?>

<?php
if (!is_user_logged_in()) {
    // Если пользователь не авторизован, перенаправить на страницу входа
    wp_redirect(home_url('/вход'));
    exit();
}
?>

<?php
get_header();
?>

<?php

$current_user = wp_get_current_user();

?>

<style>
    .course-cards-container {
        display: flex;
    }

    .information-card-wrapper {
        border: 1px solid #ccc;
        background-color: #f9f9f9;
        padding: 20px;
        text-align: center;
        margin: 50px auto;
        max-width: 600px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    }


    .user-profile-img {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        object-fit: cover;
        margin-bottom: 20px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
    }

    .user-info {
        margin-bottom: 10px;
    }

    .user-info strong {
        font-weight: bold;
    }

    .user-info span {
        color: #333;
    }

    h1 {
        margin-bottom: 20px;
        color: #333;
    }

    .logout-button {
        background-color: #00416a;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        margin-top: 20px;
    }

    .logout-button:hover {
        background-color: #2a52be;
    }
</style>
<div class="course-cards-container">
    <div class="information-card-wrapper">
        <?php

        echo '<div class="user-info">' . get_user_meta($current_user->ID, 'nickname', true) . '</div>';

        ?>

        <style>
            /* Basic styling for the dialog */
            dialog {
                border: none;
                border-radius: 5px;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                padding: 20px;
                width: 300px;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
            }
            dialog::backdrop {
                background: rgba(0, 0, 0, 0.1);
            }

            input::-webkit-outer-spin-button,
            input::-webkit-inner-spin-button {
                -webkit-appearance: none;
                margin: 0;
            }
        </style>
        <button onclick="handleAddClick()">Добавить курс</button>
        <dialog class="modalDialog" >
            <form method="post" action="<?php esc_url($_SERVER['REQUEST_URI'])?>" enctype="multipart/form-data">
                <label for="price">
                    Цена:
                    <input name="price" type="number">
                </label>
                <label for="people_count">
                    Люди:
                    <input name="people_count" type="number">
                </label>
                <label for="rating">
                    Рейтинг:
                    <input name="rating" type="number">
                </label>
                <label for="title">
                    Название:
                    <input name="title" type="text">
                </label>
                <label for="post_content">
                    Содержание курса:
                    <textarea name="post_content"></textarea>
                </label>

                <input id="cancel" type="reset" value="Очистить">
                <input type="submit" name="submitCourse" onclick="handleSubmitClick()" value="Добавить">
            </form>
        </dialog>

        <script>
            function handleAddClick(e) {
                document.querySelector('.modalDialog').showModal();
            }
            function handleSubmitClick(e) {
                document.querySelector('.modalDialog').closeModal();
            }
        </script>
        <?php
        if (isset($_POST['submitCourse'])) {
            $peopleCount = sanitize_user($_POST['people_count']);
            $rating = $_POST['rating'];
            $title = $_POST['title'];
            $price = $_POST['price'];
            $post_content = $_POST['post_content'];

            wp_insert_post(array(
                "post_content" => $post_content,
                "post_author" => $current_user->ID,
                "post_title" => $title,
                "post_status" => "pending",
                "post_type" => "course",
                "meta_input" => array(
                    "price" => $price,
                    "people_count" => $peopleCount,
                    "rating" => $rating
                )
            ));
        }
        ?>
    </div>
    <div class="information-card-wrapper ">
        <h1>Личный кабинет</h1>

        <?php

        // Вывод фото пользователя, если есть
        $avatar_url = get_avatar_url($current_user->ID);
        if ($avatar_url) {
            echo '<img class="user-profile-img" src="' . $avatar_url . '" alt="User Profile Picture">';
        }
        // Вывод логина пользователя
        echo '<div class="user-info"><strong>Логин:</strong> <span>' . $current_user->user_login . '</span></div>';

        // Вывод имени пользователя
        echo '<div class="user-info"><strong>Имя:</strong> <span>' . $current_user->display_name . '</span></div>';

        // Перевод ролей
        $role_translations = array('administrator' => 'Администратор', 'teacher_role' => 'Учитель', 'check_teacher_role' => 'Учитель на проверке', 'student_role' => 'Студент',);

        // Получение роли пользователя и вывод роли
        $user_role = get_role($current_user->roles[0]);
        if ($user_role && isset($role_translations[$user_role->name])) {
            echo '<div class="user-info"><strong>Роль:</strong> <span>' . $role_translations[$user_role->name] . '</span></div>';
        }

        // Вывод email пользователя
        echo '<div class="user-info"><strong>Email:</strong> <span>' . $current_user->user_email . '</span></div>';

        // Вывод даты регистрации
        echo '<div class="user-info"><strong>Дата регистрации:</strong> <span>' . $current_user->user_registered . '</span></div>';

        ?>

        <a href="<?php echo home_url('/выход'); ?>">Выйти из аккаунта</a>
    </div>
</div>


<?php
get_footer();
?>
