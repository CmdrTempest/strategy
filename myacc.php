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
    .close-button {
        position: absolute;
        top: 10px;
        right: 10px;
        background: none;
        border: none;
        font-size: 24px;
        cursor: pointer;
        color: #333;
    }

    .close-button:hover {
        color: #000;
    }

</style>
<div class="course-cards-container">
    <div class="information-card-wrapper">
        <style>
            dialog {
                border: none;
                border-radius: 5px;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                padding: 20px;
                width: calc(100%-100px);
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
        <button onclick="handleCourseClick()">Мои курсы</button>
        <dialog class="modalDialog" id="addCourseDialog">
            <button class="close-button" onclick="closeDialog('addCourseDialog')">&times;</button>
            <form method="post" action="<?php esc_url($_SERVER['REQUEST_URI'])?>" enctype="multipart/form-data">
                <label for="price">
                    Цена:
                    <input name="price" type="number">
                </label>
                <br>
                <label for="people_count">
                    Люди:
                    <input name="people_count" type="number">
                </label>
                <br>
                <label for="rating">
                    Рейтинг:
                    <input name="rating" type="number">
                </label>
                <br>
                <label for="title">
                    Название:
                    <input name="title" type="text">
                </label>
                <br>
                <label for="hours">
                    Часы:
                    <input name="hours" type="number">
                </label>
                <br>
                <label for="post_content">
                    Содержание курса:
                    <textarea name="post_content"></textarea>
                </label>
                <br>
                <label for="course_image">
                    Шапка курса:
                    <input name="course_image" type="file" accept=".png, .jpg, .jpeg">
                </label>
                <hr>

                <input id="cancel" type="reset" value="Очистить">
                <input type="submit" name="submitCourse" onclick="handleSubmitClick()" value="Добавить">
            </form>
        </dialog>
        <dialog class="modalDialog" id="courseDashboardDialog">
            <button class="close-button" onclick="closeDialog('courseDashboardDialog')">&times;</button>
            <div class="boxes d-flex clearfix">
                <?php
                $args = array(
                    'post_type'      => 'course',
                    'posts_per_page' => 9,
                    'author' => get_current_user_id(),
                );

                $query = new WP_Query($args);

                if ($query->have_posts()) :
                    while ($query->have_posts()) : $query->the_post();
                        ?>
                        <div class="box">
                            <figure>
                                <?php
                                if (has_post_thumbnail()) {
                                    the_post_thumbnail('thumbnail', array('width' => 280, 'height' => 200));
                                }
                                ?>
                                <figcaption>
                                    <p><strong>Цена:</strong> <span class="price"><?php echo get_post_meta(get_the_ID(), 'цена', true); ?></span> рублей за урок</p>
                                    <p><strong>Часы:</strong> <?php echo get_post_meta(get_the_ID(), 'hours', true); ?></p>
                                    <p><strong>Люди:</strong> <?php echo get_post_meta(get_the_ID(), 'people-count', true); ?></p>
                                    <p><strong>Рейтинг:</strong> <?php echo get_post_meta(get_the_ID(), 'rating', true); ?>/5</p>
                                </figcaption>
                                <p class="title"><?php the_title(); ?></p>
                            </figure>
                        </div>
                    <?php
                    endwhile;
                    wp_reset_postdata();
                else :
                    echo 'Курсы не найдены.';
                endif;
                ?>
            </div>
        </dialog>

        <script>
            function handleAddClick(e) {
                document.querySelector('#addCourseDialog').showModal();
            }
            function handleCourseClick(e) {
                document.querySelector('#courseDashboardDialog').showModal();
            }
            function handleSubmitClick(e) {
                document.querySelector('#addCourseDialog').closeModal();
            }
            function closeDialog(dialogId) {
                document.getElementById(dialogId).close();
            }

        </script>
        <?php
        if (isset($_POST['submitCourse'])) {
            $peopleCount = sanitize_user($_POST['people_count']);
            $rating = $_POST['rating'];
            $title = $_POST['title'];
            $price = $_POST['price'];
            $post_content = $_POST['post_content'];
            $hours = $_POST['hours'];
            $uploaded_file = wp_upload_bits( $_FILES['course_image']['name'], null, file_get_contents( $_FILES['course_image']['tmp_name'] ) );

            if ( ! $uploaded_file['error'] ) {
                $file_path = $uploaded_file['file'];
                $file_name = basename( $file_path );
                $file_type = wp_check_filetype( $file_name, null );

                // Prepare an array of post data for the attachment.
                $attachment = array(
                    'guid'           => $uploaded_file['url'],
                    'post_mime_type' => $file_type['type'],
                    'post_title'     => sanitize_file_name( $file_name ),
                    'post_content'   => '',
                    'post_status'    => 'inherit'
                );

                // Insert the attachment.
                $attach_id = wp_insert_attachment( $attachment, $file_path );

                // Make sure that this file is included, because we will need it later.
                require_once( ABSPATH . 'wp-admin/includes/image.php' );

                // Generate the metadata for the attachment, and update the database record.
                $attach_data = wp_generate_attachment_metadata( $attach_id, $file_path );
                wp_update_attachment_metadata( $attach_id, $attach_data );


                $post = wp_insert_post(array(
                    "post_content" => $post_content,
                    "post_author" => $current_user->ID,
                    "post_title" => $title,
                    "post_status" => "pending",
                    "post_type" => "course",
                    "meta_input" => array(
                        "цена" => $price,
                        "people_count" => $peopleCount,
                        "rating" => $rating,
                        "hours" => $hours,
                    )
                ));
                set_post_thumbnail( $post, $attach_id );

            }


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
