<?php

namespace Gamify\Http\Controllers\Admin;

use Gamify\User;
use Gamify\Question;
use Gamify\Http\Requests\QuestionCreateRequest;
use Gamify\Http\Requests\QuestionUpdateRequest;
use yajra\Datatables\Datatables;


class AdminQuestionController extends AdminController
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin/question/index');
    }

    /**
     * Displays the form for question creation
     *
     *  @return \Illuminate\Http\Response
     *
     */
    public function create()
    {
        return view('admin/question/create');
    }

    /**
     * Stores new question
     *
     * @param QuestionCreateRequest $request
     * @return \Illuminate\Http\Response
     *
     */
    public function store(QuestionCreateRequest $request)
    {
        Question::create($request->all());

        return redirect()->route('admin.questions.index')
            ->with('success', trans('admin/question/messages.create.success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  Question $question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
        return view('admin/question/show', compact('question'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Question $question
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question)
    {
        return view('admin/question/edit', compact('question'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $question
     * @return Response
     */
    public function update(QuestionUpdateRequest $request, Question $question)
    {
        $question->fill($request->all())->save();

        return redirect()->route('admin.questions.index')
            ->with('success', trans('admin/question/messages.update.success'));
    }

    /**
     * Remove question page.
     *
     * @param $question
     * @return Response
     */
    public function delete(Question $question)
    {
        return view('admin/question/delete', compact('question'));
    }

    /**
     * Remove the specified question from storage.
     *
     * @param $question
     * @return Response
     */
    public function destroy(Question $question)
    {
        $question->delete();

        return redirect()->route('admin.questions.index')
            ->with('success', trans('admin/question/messages.delete.success'));
    }

    /**
     * Show a list of all the questions formatted for Datatables.
     *
     * @param Datatables $dataTable
     * @return JsonResponse

     */
    public function data(Datatables $dataTable)
    {
        // TODO: Disable this query if isn't AJAX

        $question = Question::select([
            'id', 'shortname', 'name', 'status'
        ])->orderBy('name', 'ASC');

        $statusLabel = array(
            'draft' => '<span class="label label-default ">' . trans('admin/question/model.draft') . '</span>',
            'publish' => '<span class="label label-success ">' . trans('admin/question/model.publish') . '</span>',
            'unpublish' => '<span class="label label-inverse ">' . trans('admin/question/model.unpublish') . '</span>',
        );

        return $dataTable->of($question)
            ->editColumn('status', function(Question $question) use ($statusLabel) {
                return $statusLabel[$question->status];
            })
            ->addColumn('actions', function(Question $question) {
                return view('admin/partials.actions_dd', array(
                        'model' => 'questions',
                        'id' => $question->id)
                )->render();
            })
            ->removeColumn('id')
            ->make(true);
    }

}
