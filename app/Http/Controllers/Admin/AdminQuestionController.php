<?php

namespace Gamify\Http\Controllers\Admin;

use Gamify\User;
use Illuminate\Http\Request;

use Gamify\Http\Requests;
use Gamify\Question;

use yajra\Datatables\Datatables;


class AdminQuestionController extends AdminController
{

    public function index()
    {
        $title = trans('admin/question/title.question_management');

        $table = Datatable::table()
            ->addColumn(
                trans('admin/question/table.shortname'),
                trans('admin/question/table.name'),
                trans('admin/question/table.image'),
                trans('admin/question/table.status'),
                trans('admin/question/table.created_at'),
                trans('table.actions')
            )
            ->setUrl(route('admin.questions.data'))
            ->noScript();

        // The list of questions will be filled later using the JSON Data method
        // below - to populate the DataTables table.
        return view('admin/question/index', compact('title', 'table'));
    }

    /**
     * Displays the form for question creation
     *
     */
    public function create()
    {
        $title = trans('admin/question/title.create_a_new_question');
        return view('admin/question/create', compact('title'));
    }

    /**
     * Stores new question
     *
     */
    public function store()
    {
        $input = Input::all();
        $validation = Validator::make($input, Question::$rules);

        if ($validation->passes()) {
            Question::create($input);

            return Redirect::route('admin.questions.index')
                ->with('success', trans('admin/question/messages.create.success'));
        }

        return Redirect::route('admin.questions.create')
            ->withInput()
            ->withErrors($validation);
    }

    /**
     * Show a single question details page.
     *
     * @param $question
     * @return Response
     */
    public function show(Question $question)
    {
        $title = trans('admin/question/title.question_show');
        return view('admin/question/show', compact('question', 'title'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $question
     * @return Response
     */
    public function edit(Question $question)
    {
        $title = trans('admin/question/title.question_update');
        return view('admin/question/edit', compact('question', 'title'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $question
     * @return Response
     */
    public function update(Question $question)
    {
        $input = Input::all();
        $validation = Validator::make($input, Question::$rules);

        if ($validation->passes()) {
            $question->update($input);

            return Redirect::route('admin.questions.index')
                ->with('success', trans('admin/question/messages.update.success'));
        }

        return Redirect::route('admin.questions.edit')
            ->withInput()
            ->withErrors($validation);
    }

    /**
     * Remove question page.
     *
     * @param $question
     * @return Response
     */
    public function delete(Question $question)
    {
        $title = trans('admin/question/title.question_delete');
        return view('admin/question/delete', compact('question', 'title'));
    }

    /**
     * Remove the specified question from storage.
     *
     * @param $question
     * @return Response
     */
    public function destroy(Question $question)
    {
        $id = $question->id;
        $question->delete();

        // Was the question deleted?
        if (Question::find($id)) {
            // There was a problem deleting the question
            return Redirect::route('admin.questions.index')
                ->with('error', trans('admin/question/messages.delete.error'));
        }
        // Redirect to the question management page
        return Redirect::route('admin.questions.index')
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
        /*
         *
         if ( ! Request::ajax()) {
            abort(403);
        }
        */

        $data = User::all();
        return Datatables::of($data)->make(true);

        $statusLabel = array(
            'draft' => '<span class="label label-default ">' . trans('admin/question/model.draft') . '</span>',
            'publish' => '<span class="label label-success ">' . trans('admin/question/model.publish') . '</span>',
            'unpublish' => '<span class="label label-inverse ">' . trans('admin/question/model.unpublish') . '</span>',
        );

        return $dataTable->of($data)
            ->showColumns('shortname', 'name', 'image', 'status', 'created_at', 'actions')
            ->addColumn('image', function($model) {
                return '<img src="' . $model->image->url('small') . '" width="64" class="img-thumbnail" />';
            })
/*            ->addColumn('actions', function($model) {
                return view('partials.admin_actions_dd', array(
                        'model' => 'questions',
                        'id' => $model->id)
                )->render();
            })
            ->addColumn('status', function($model) use ($statusLabel) {
                return $statusLabel[$model->status];
            })
*/
            ->searchColumns('shortname', 'name', 'status', 'created_at')
            ->orderColumns('created_at', 'name', 'status', 'status')
            ->make();
    }

}
