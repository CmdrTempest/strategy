<?php
/*
Template Name: test editor
*/

get_header();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submitTest'])) {
    $number = 1; // Assuming only one question is being processed at a time
    $theory = isset($_POST["theory-$number"]) ? sanitize_text_field($_POST["theory-$number"]) : '';
    $question = isset($_POST["question-$number"]) ? sanitize_text_field($_POST["question-$number"]) : '';
    $answer1 = isset($_POST["answer-$number-1"]) ? sanitize_text_field($_POST["answer-$number-1"]) : '';
    $answer2 = isset($_POST["answer-$number-2"]) ? sanitize_text_field($_POST["answer-$number-2"]) : '';
    $answer3 = isset($_POST["answer-$number-3"]) ? sanitize_text_field($_POST["answer-$number-3"]) : '';
    $answer4 = isset($_POST["answer-$number-4"]) ? sanitize_text_field($_POST["answer-$number-4"]) : '';
    $correct_answer = isset($_POST["correct_answer_$number"]) ? sanitize_text_field($_POST["correct_answer_$number"]) : '';

    // Get the ID of the post to update (replace 123 with the actual post ID or obtain it dynamically)
    $post_id = 63; // Replace with the actual post ID

    $abcd = "abcd";
    $content = $theory;
    $test_array = array(
        'question' => $question,
        'answers' => array(
            'a' => $answer1,
            'b' => $answer2,
            'c' => $answer3,
            'd' => $answer4,
        ),
        'correctAnswer' => $abcd[$correct_answer - 1] 
    );

    // Update the post
    $post_data = array(
        'ID' => $post_id,
        'post_content' => $content,
        'meta_input' => array(
            'test' => json_encode($test_array),
        ),
    );

    wp_update_post($post_data);
}

echo get_question_editor(1);

get_footer();
?>
