<?php

namespace Gamify\Http\Controllers\Admin;

use Gamify\QuestionChoice;
use Gamify\Question;
use Gamify\Http\Requests\QuestionChoiceCreateRequest;
use Gamify\Http\Requests\QuestionChoiceUpdateRequest;

class AdminQuestionChoiceController extends AdminController
{
    /**
     * Show the form for creating a new resource.
     *
     * @param Question $question
     * @return \Illuminate\Http\Response
     */
    public function create(Question $question)
    {
        return view('admin/choice/create', compact('question'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Question $question
     * @param  QuestionChoiceCreateRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(Question $question, QuestionChoiceCreateRequest $request)
    {
        $question->choices()->create($request->all());

        return redirect()->route('admin.questions.edit', $question)
            ->with('success', trans('admin/choice/messages.create.success'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Question $question
     * @param  QuestionChoice $choice
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question, QuestionChoice $choice)
    {
        return view('admin/choice/edit', compact('question', 'choice'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Question $question
     * @param  QuestionChoiceUpdateRequest  $request
     * @param  QuestionChoice $choice
     * @return \Illuminate\Http\Response
     */
    public function update(Question $question, QuestionChoiceUpdateRequest $request, QuestionChoice $choice)
    {
        $choice->update($request->all());

        return redirect()->route('admin.questions.edit', $question)
            ->with('success', trans('admin/choice/messages.create.success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Question $question
     * @param  QuestionChoice $choice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question, QuestionChoice $choice)
    {
        $choice->delete();

        return redirect()->route('admin.questions.edit', $question)
            ->with('success', trans('admin/choice/messages.delete.success'));
    }
}
