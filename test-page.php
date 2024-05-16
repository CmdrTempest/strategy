<?php
/*
Template Name: Tests Page
*/

get_header();
?>

<style>
.u-section-2 {
    background-image: linear-gradient(to bottom, #2980b9, #2c3e50);
    color: #fff;
    font-weight: bold;
    padding: 25px;
}

.button-container {
    display: flex;
    justify-content: space-around;
    margin-bottom: 20px;
}

.button-container button {
    cursor: pointer;
    background-color: #3498db;
    border: none;
    color: #fff;
    padding: 10px 20px;
    border-radius: 5px;
}

.button-container button:hover {
    background-color: #2f7e2f;
}
</style>

<section class="u-section-2">
    <h1>Выберите тест</h1>

    <div class="button-container">
        <button onclick="redirectToTest('test1')">Выпускной тест</button>
        <button onclick="redirectToTest('test2')">Тест 2</button>
        <button onclick="redirectToTest('test3')">Тест 3</button>
        <button onclick="redirectToTest('test4')">Тест 4</button>
        <button onclick="redirectToTest('test5')">Тест 5</button>
    </div>

    <script>
        function redirectToTest(testName) {
            // Перенаправляем пользователя на страницу с выбранным тестом
            window.location.href = '<?php echo esc_url(home_url('/')); ?>' + 'тестирование/';
        }
    </script>
</section>

<?php get_footer(); ?>
