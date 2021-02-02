<?php

namespace App\Orchid\Screens;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Cropper;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class PostEditScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Post';

    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = 'Postni yangilash';
    /**
     * @var bool
     */
    public $exists = false;

    /**
     * Query data.
     *
     * @return array
     */
    public function query(Post $post): array
    {
        if (isset($post)) {
            $this->exists = $post->exists;
        }
        if ($this->exists){
            $this->name = 'Edit Post';
        }
        return [
            'post' => $post
        ];
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [
            Button::make('Create post')
                ->icon('pencil')
                ->method('createOrUpdate')
                ->canSee(!$this->exists),

            Button::make('Update')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->exists),

            Button::make('Remove')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->exists),
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): array
    {
        return [
            Layout::rows([
                Input::make('post.title')
                    ->title('Title')
                    ->placeholder('Title'),
                // image cropper
                Cropper::make('post.hero')
                    ->title('Post image upload')
                    ->width(1000)
                    ->height(500)
                    ->targetId(),

                TextArea::make('post.description')
                    ->title('Description')
                    ->rows(3)
                    ->maxlength(200)
                    ->placeholder('Description'),

                Relation::make('post.author')
                    ->title('Author')
                    ->fromModel(User::class, 'name'),


                Quill::make('post.body')
                    ->toolbar(["text", "color", "header", "list", "format", "media"])
                    ->title('Main text'),

            ])];
    }
    /**
     * @param Post    $post
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createOrUpdate(Post $post, Request $request)
    {
        $post->fill($request->get('post'))->save();

        Alert::info('You have successfully created an post.');

        return redirect()->route('platform.post.list');
    }

}
