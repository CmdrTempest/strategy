<?php
/*
Template Name: test1
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

body {
    display: flex;
    min-height: 100vh;
    flex-direction: column;
    margin: 0;
    font-family: Arial, sans-serif;
}

h1, h3 {
    margin-top: 0;
}

input[type="radio"] {
    margin-right: 5px;
}

button {
    cursor: pointer;
    background-color: #3498db;
    border: none;
    color: #fff;
    padding: 10px 20px;
    border-radius: 5px;
    margin-top: 10px;
}

button:hover {
    background-color: #2f7e2f;
}
</style>

<section class="u-section-2">
    <h1>Выпускной тест</h1>

    <?php
    // Массив с вопросами и правильными ответами
    $questions = array(
        array(
            'question' => 'Кто является автором "Лунной сонаты"?',
            'answers' => array(
                'a' => 'Моцарт',
                'b' => 'Бетховен',
                'c' => 'Чайковский',
                'd' => 'Вивальди'
            ),
            'correctAnswer' => 'b'
        ),
        array(
            'question' => 'Какой композитор написал оперу "Кармен"?',
            'answers' => array(
                'a' => 'Верди',
                'b' => 'Моцарт',
                'c' => 'Бизе',
                'd' => 'Григ'
            ),
            'correctAnswer' => 'c'
        ),
        array(
            'question' => 'Какой инструмент играет Йо-Йо Ма?',
            'answers' => array(
                'a' => 'Скрипка',
                'b' => 'Виолончель',
                'c' => 'Флейта',
                'd' => 'Треугольник'
            ),
            'correctAnswer' => 'b'
        ),
        array(
            'question' => 'Как называется главный мотив из симфонии Бетховена №9?',
            'answers' => array(
                'a' => 'Трель',
                'b' => 'Ода к радости',
                'c' => 'Реквием'
            ),
            'correctAnswer' => 'b'
        ),
        array(
            'question' => 'Какой композитор написал оперу "Фигаро-опера"?',
            'answers' => array(
                'a' => 'Моцарт',
                'b' => 'Верди',
                'c' => 'Мендельсон'
            ),
            'correctAnswer' => 'a'
        )
    );

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Обработка отправленных ответов
        $score = 0;
        foreach ($questions as $index => $question) {
            $userAnswer = $_POST['q' . ($index + 1)];
            if ($userAnswer == $question['correctAnswer']) {
                $score++;
            }
        }
        echo '<h2 style="text-align: center;">Результаты теста</h2>';
        echo '<p style="text-align: center;">Вы ответили правильно на ' . $score . ' из ' . count($questions) . ' вопросов.</p>';
    }
    ?>

    <form id="quizForm" action="" method="post">
        <?php foreach ($questions as $index => $question) { ?>
            <div class="question" id="question<?php echo ($index + 1); ?>">
                <h3><?php echo $question['question']; ?></h3>
                <?php foreach ($question['answers'] as $key => $answer) { ?>
                    <input type="radio" name="q<?php echo ($index + 1); ?>" value="<?php echo $key; ?>">
                    <?php echo $answer; ?><br>
                <?php } ?>
                <?php if ($index < count($questions) - 1) { ?>
                    <button type="button" class="next-button" onclick="nextQuestion(this, '<?php echo $question['correctAnswer']; ?>')">Следующий вопрос</button>
                <?php } else { ?>
                    <div class="center-button-container">
                        <p class="correct-answer" id="correctAnswer<?php echo ($index + 1); ?>"></p>
                        <button type="button" class="check-answer-button" onclick="checkAnswer(this, '<?php echo $question['correctAnswer']; ?>', '<?php echo $question['answers'][$question['correctAnswer']]; ?>')">Проверить ответ</button>
                    </div>
                    <div class="center-button-container">
                        <button type="submit" style="display: none;">Завершить тест</button>
                    </div>
                <?php } ?>
                <?php if ($index < count($questions) - 1) { ?>
                    <p class="correct-answer" id="correctAnswer<?php echo ($index + 1); ?>" style="display: none;">Правильный ответ: <?php echo $question['answers'][$question['correctAnswer']]; ?></p>
                <?php } ?>
            </div>
        <?php } ?>
    </form>

    <script>
        var currentQuestion = 1;

        function showQuestion(questionNumber) {
            var questions = document.getElementsByClassName("question");
            for (var i = 0; i < questions.length; i++) {
                questions[i].style.display = "none";
            }
            questions[questionNumber - 1].style.display = "block";
        }

        function nextQuestion(button, correctAnswer) {
            var userAnswer = document.querySelector('input[name="q' + currentQuestion + '"]:checked');
            if (userAnswer !== null) {
                if (userAnswer.value !== correctAnswer) {
                    var previousCorrectAnswer = document.getElementById("correctAnswer" + currentQuestion);
                    previousCorrectAnswer.style.display = "block";
                }
                currentQuestion++;
                showQuestion(currentQuestion);
                button.style.display = "none";
            } else {
                alert("Пожалуйста, выберите ответ перед переходом к следующему вопросу.");
            }
        }

        function checkAnswer(button, correctAnswer, correctAnswerText) {
            var userAnswer = document.querySelector('input[name="q' + currentQuestion + '"]:checked');
            if (userAnswer !== null) {
                if (userAnswer.value !== correctAnswer) {
                    var previousCorrectAnswer = document.getElementById("correctAnswer" + currentQuestion);
                    previousCorrectAnswer.style.display = "block";
                }
                button.style.display = "none";
                var submitButton = document.querySelector('button[type="submit"]');
                submitButton.style.display = "block";
            } else {
                alert("Пожалуйста, выберите ответ перед проверкой.");
            }
        }

        showQuestion(currentQuestion);
    </script>
</section>

<?php get_footer(); ?>
