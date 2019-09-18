<?php

/**
 * Class file for feedback collected, mapped to feedback_master table.
 * 
 * @author Anoop Santhanam <anoop.santhanam@gmail.com>
 */
class Feedback
{
    /**
     * The current object's feedback ID
     */
    private $feedbackId = false;

    /**
     * Flag to check if the current feedback is valid
     */
    public $feedbackValid = false;

    /**
     * Stores the app var
     */
    public $app = false;

    public function __construct($feedbackId = false)
    {
        $this->app = $GLOBALS['app'];
        if ($feedbackId && is_numeric($feedbackId)) {
            $this->feedbackId = $feedbackId;
            $this->feedbackValid = $this->verifyFeedback();
        }
    }

    /**
     * Validates a feedback
     * 
     * @return bool
     */
    public function validateFeedback(): bool
    {
        if ($this->feedbackId) {
            $feedbackId = $this->feedbackId;
            $app = $this->app;
            $query = "SELECT idfeedback_master FROM feedback_master WHERE idfeedback_master = '$feedbackId' AND deleted_at IS NULL";
            if (!empty($query = $app['db']->fetchAssoc($query))) {
                return true;
            }
        } 

        return false;
    }

    /**
     * Adds a feedback to the database.
     * 
     * @param array  $answers The array of answers
     * @param string $number  The user's phone number, default to ''
     */
    public function addFeedback($answers, $number = ''): bool
    {
        if (!empty($answers)) {
            $app = $this->app;
            $answer1 = $answers[0];
            $answer2 = $answers[1];
            $answer3 = $answers[2];

            $in = "INSERT INTO feedback_master (created_at, question_1, question_2, question_3, user_number) VALUES (NOW(), '$answer1', '$answer2', '$answer3', '$number')";
            $app['db']->executeQuery($in);

            return true;
        }

        return false;
    }
}