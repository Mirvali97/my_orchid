<?php

namespace App\Orchid\Screens;

use App\Models\Post;
use App\Orchid\Layouts\PostListLayout;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;

class PostListScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Postlar';

    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = 'Barcha Postlar';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'posts' => Post::filters()->defaultSort('id')->paginate()
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
            Link::make('Yangi Post Yaratish')
                ->icon('pencil')
                ->route('platform.post.edit'),
        ];
    }

    /**
     * @param Post $post
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function remove(Post $post)
    {
        $post->delete();
        Alert::info('You have successfully deleted the post.');

        return redirect()->route('platform.post.list');
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): array
    {
        return [
            PostListLayout::class
        ];
    }
}
