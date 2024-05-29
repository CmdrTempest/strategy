<?php
/*
Template Name: Test Editor
*/

$competition_id = isset($_GET['competition_id']) ? intval($_GET['competition_id']) : 0;
$test_id = isset($_GET['test_id']) ? intval($_GET['test_id']) : 0;

if(($test_id != 0) & (get_post_field('post_author', $test_id) != get_current_user_id())) {
    wp_redirect(home_url());
    exit();
}

// Fetch existing questions
$questions_json = '';
if ($competition_id) {
    $questions_json = get_post_meta($competition_id, '_competition_tests', true);
} elseif ($test_id) {
    $questions_json = get_post_meta($test_id, 'test', true);
}

get_header();
?>

<div id="test-editor-app">
    <h1>Редактор тестов</h1>
    <form id="test-editor-form">
        <div id="questions-container">
        </div>
        <button type="button" id="add-question">Добавить вопрос</button>
        <button type="submit">Сохранить тест</button>
    </form>
</div>

<?php get_footer(); ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    (function($) {
        $(document).ready(function() {
            function jsonToArray(jsonString) {
                const jsonObj = JSON.parse(jsonString);
                const array = [];

                for (const key in jsonObj) {
                    if (jsonObj.hasOwnProperty(key)) {
                        array[key - 1] = jsonObj[key];
                    }
                }

                return array;
            }

            const questions = jsonToArray('<?php echo $questions_json ?>');
            const questionsContainer = '#questions-container';

            // Function to render questions
            function renderQuestions() {
                $(questionsContainer).empty();
                questions.forEach((question, index) => {
                    // language=HTML
                    $(questionsContainer).append(`
                        <div class="question-block" data-question-id="${index + 1}">
                            <h3>Вопрос ${index + 1}</h3>
                            <label>Вопрос:
                                <input type="text" name="questions[${index + 1}][question]" value="${question.question}" required>
                            </label>
                            <label>Ответ A:
                                <input type="text" name="questions[${index + 1}][answers][a]" value="${question.answers.a}" required>
                            </label>
                            <label>Ответ B:
                                <input type="text" name="questions[${index + 1}][answers][b]" value="${question.answers.b}" required>
                            </label>
                            <label>Ответ C:
                                <input type="text" name="questions[${index + 1}][answers][c]" value="${question.answers.c}" required>
                            </label>
                            <label>Ответ D:
                                <input type="text" name="questions[${index + 1}][answers][d]" value="${question.answers.d}" required>
                            </label>
                            <label>Правильный ответ:
                                <select name="questions[${index + 1}][correctAnswer]" required>
                                    <option value="a" ${question.correctAnswer === 'a' ? 'selected' : ''}>A</option>
                                    <option value="b" ${question.correctAnswer === 'b' ? 'selected' : ''}>B</option>
                                    <option value="c" ${question.correctAnswer === 'c' ? 'selected' : ''}>C</option>
                                    <option value="d" ${question.correctAnswer === 'd' ? 'selected' : ''}>D</option>
                                </select>
                            </label>
                            <button type="button" class="delete-question">Удалить вопрос</button>
                        </div>
                    `);
                });
            }

            function addQuestion() {
                questions.push({
                    question: '',
                    answers: { a: '', b: '', c: '', d: '' },
                    correctAnswer: 'a'
                });
                renderQuestions();
            }

            function deleteQuestion(index) {
                questions.splice(index, 1);
                renderQuestions();
            }

            $('#add-question').on('click', function() {
                addQuestion();
            });

            $(questionsContainer).on('click', '.delete-question', function() {
                const questionIndex = $(this).closest('.question-block').data('question-id') - 1;
                deleteQuestion(questionIndex);
            });

            // Form submission event
            $('#test-editor-form').on('submit', function(e) {
                e.preventDefault();

                const formData = $(this).serialize();
                const competitionId = new URLSearchParams(window.location.search).get('competition_id') || 0;
                const testId = new URLSearchParams(window.location.search).get('test_id') || 0;

                $.ajax({
                    url: '/wp-admin/admin-ajax.php',
                    type: 'POST',
                    data: {
                        action: 'save_test',
                        competition_id: competitionId,
                        test_id: testId,
                        form_data: formData
                    },
                    success: function(response) {
                        if (response.success) {
                            alert(response.data.message);
                        } else {
                            alert('Ошибка: ' + response.data.message);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert('Ошибка AJAX: ' + textStatus + ' - ' + errorThrown);
                    }
                });
            });

            // Initial render
            renderQuestions();
        });
    })(jQuery);
</script>
