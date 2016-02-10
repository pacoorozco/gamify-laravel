<?php

namespace Gamify\Http\Controllers\Admin;

use Gamify\Http\Requests\QuestionActionCreateRequest;
use Gamify\Http\Requests\QuestionActionUpdateRequest;
use Gamify\Question;
use Gamify\QuestionAction;

class AdminQuestionActionController extends AdminController {

    /**
     * Show the form for creating a new resource.
     *
     * @param  Question $question
     * @return \Illuminate\Http\Response
     */
    public function create(Question $question)
    {
        $availableActions = array();

        // get actions that hasn't not been used
        foreach($question->getAvailableActions() as $action) {
            $availableActions[$action->id] = $action->name;
        }

        return view('admin/action/create', compact('question', 'availableActions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Question $question
     * @param  QuestionActionCreateRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(Question $question, QuestionActionCreateRequest $request)
    {
        $question->actions()->create($request->all());

        return redirect()->route('admin.questions.edit', $question)
            ->with('success', trans('admin/action/messages.create.success'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * TODO - Not implemented on routes.php
     *
     * @param  Question $question
     * @param  QuestionAction $action
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question, QuestionAction $action)
    {
        return view('admin/action/edit', compact('question', 'action'));
    }

    /**
     * Update the specified resource in storage.
     *
     * TODO - Not implemented on routes.php
     *
     * @param  Question $question
     * @param  QuestionActionUpdateRequest $request
     * @param  QuestionAction $action
     * @return \Illuminate\Http\Response
     */
    public function update(Question $question, QuestionActionUpdateRequest $request, QuestionAction $action)
    {
        $action->update($request->all());

        return redirect()->route('admin.questions.edit', $question)
            ->with('success', trans('admin/action/messages.create.success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Question $question
     * @param  QuestionAction $action
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question, QuestionAction $action)
    {
        $action->delete();

        return redirect()->route('admin.questions.edit', $question)
            ->with('success', trans('admin/action/messages.delete.success'));
    }
}
