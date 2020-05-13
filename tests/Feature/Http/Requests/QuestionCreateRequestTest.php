<?php

namespace Tests\Feature\Http\Requests;

use Gamify\Http\Requests\QuestionCreateRequest;
use Gamify\TestDataGenerator\QuestionTestDataGenerator;
use Tests\TestCase;
use Tests\ValidationAssertions;

class QuestionCreateRequestTest extends TestCase
{
    use ValidationAssertions;

    private $rules;

    public function setUp(): void
    {
        parent::setUp();
        $validator = new QuestionCreateRequest();
        $this->rules = $validator->rules();
    }

    /** @test */
    public function it_returns_no_error_when_it_validates_a_valid_question()
    {
        $input_data = QuestionTestDataGenerator::FormRequestData();

        $this->assertValidationPasses($input_data, $this->rules);
    }

    /** @test */
    public function it_returns_error_when_trying_to_validate_a_question_without_a_name()
    {
        $input_data = QuestionTestDataGenerator::FormRequestData([
            'name' => null,
        ]);

        $this->assertValidationHasError('name', $input_data, $this->rules);
    }

    /** @test */
    public function it_returns_error_when_trying_to_validate_a_question_without_a_question_text()
    {
        $input_data = QuestionTestDataGenerator::FormRequestData([
            'question' => null,
        ]);

        $this->assertValidationHasError('question', $input_data, $this->rules);
    }

    /** @test */
    public function it_returns_error_when_trying_to_validate_a_question_without_a_valid_type()
    {
        $input_data = QuestionTestDataGenerator::FormRequestData([
            'type' => null,
        ]);

        $this->assertValidationHasError('type', $input_data, $this->rules);
    }

    /** @test */
    public function it_returns_error_when_trying_to_validate_a_question_without_a_valid_status()
    {
        $input_data = QuestionTestDataGenerator::FormRequestData([
            'status' => null,
        ]);

        $this->assertValidationHasError('status', $input_data, $this->rules);
    }

    /** @test */
    public function it_returns_error_when_trying_to_validate_a_question_without_choices()
    {
        $input_data = QuestionTestDataGenerator::FormRequestData([
            'choice_text' => null,
        ]);

        $this->assertValidationHasError('choice_text', $input_data, $this->rules);
    }

    /** @test */
    public function it_returns_error_when_trying_to_validate_a_question_without_choice_score()
    {
        $input_data = QuestionTestDataGenerator::FormRequestData([
            'choice_score' => null,
        ]);

        $this->assertValidationHasError('choice_score', $input_data, $this->rules);
    }

    /** @test */
    public function it_returns_error_when_trying_to_validate_a_question_without_valid_choice_score()
    {
        $input_data = QuestionTestDataGenerator::FormRequestData([
            'choice_score' => ['invalid-value', -5], // First option has an invalid value
        ]);

        $this->assertValidationHasError('choice_score.0', $input_data, $this->rules);
    }
}
