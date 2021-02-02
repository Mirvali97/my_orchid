<?php

namespace App\Orchid\Layouts;

use App\Models\Post;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class PostListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'posts';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): array
    {
        return [
            TD::make('title', 'Title')
                ->sort()
                ->filter(TD::FILTER_TEXT)
                ->render(function (Post $post) {
                    return Link::make($post->title)
                        ->route('platform.post.edit', $post);
                }),
            TD::make('description', 'Description')
                ->sort()
                ->filter(TD::FILTER_TEXT)
                ->render(function (Post $post) {
                    return Link::make($post->description)
                        ->route('platform.post.edit', $post);
                }),

            TD::make('description', 'Description')
                ->sort()
                ->filter(TD::FILTER_TEXT)
                ->render(function (Post $post) {
                    return Link::make($post->description)
                        ->route('platform.post.edit', $post);
                }),
            TD::make('created_at', 'Created')
                ->sort()
                ->render(function (Post $post) {
                    return $post->created_at->toDateTimeString();
                }),

            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(function (Post $post) {
                    return DropDown::make()
                        ->icon('options-vertical')
                        ->list([

                            Link::make(__('Edit'))
                                ->route('platform.post.edit', $post->id)
                                ->icon('pencil'),

                            Button::make(__('Delete'))
                                ->icon('trash')
                                ->method('remove')
                                ->confirm('Post Bo\'tunlay o\'chib ketadi')
                                ->parameters([
                                    'id' => $post->id,
                                ]),
                        ]);
                }),
        ];
    }
}
