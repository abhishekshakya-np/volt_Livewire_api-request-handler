<?php

use App\Models\Post;
use function Livewire\Volt\{state, usesFileUploads, computed, rules};

usesFileUploads();

state([
    'title' => '',
    'body' => '',
    'image' => null,
    'posts'=>fn() => Post::all()
]);

rules(['title' => 'required|min:3',
    'body' => 'required|min:20',
    'image' => 'nullable|max:2024']);


$addPost = function () {
    $this->validate();
    Post::create([
        'title' => $this->title,
        'body' => $this->body,
        //   'image' => $this->image ? $this->image->store('posts') : null,
       'image' => $this->image->store('posts')
    ]);
    $this->title = '';
    $this->body = '';

    $this->posts = Post::all(); // Refresh posts after adding a new one
};

$deletePost = function (Post $post) {
    \Illuminate\Support\Facades\Storage::delete($post->image);
        $post->delete();// Refresh posts after deletion

};


//No Validation: The function directly creates a Post record without checking the validity of the inputs.
//Potential Issues: This approach can lead to invalid or malicious data being stored in the database, compromising data integrity and security.


/*
$addPost = function () {
$this->validate([
    'title' => 'required|string|max:255',
    'body' => 'required|string',
    'image' => 'nullable|image|max:1024', // Assuming image upload validation
]);

Post::create([
    'title' => $this->title,
    'body' => $this->body,
    'image' => $this->image ? $this->image->store('posts') : null,
]);

// Reset the form state
state([
    'title' => '',
    'body' => '',
    'image' => null,
]);
};
//Validation Step: The validate method checks if the inputs meet the specified criteria before proceeding with the creation of the Post record.
//Post Creation: If validation passes, the Post::create method is called to store the validated data.
//State Reset: The form state is reset to clear the inputs after successful submission.
//Without Validation
*/

?>

<div class="max-w-6xl mx-auto bg-slate-100 rounded">
    <div class="my-4">
        <form wire:submit="addPost" class="p-4 space-y-2" enctype="multipart/form-data">
            <div>
                <label for="title" class="block text-gray-700">Title</label>
                <input type="text" wire:model="title" name="title" id="title"
                       class="block w-full px-4 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md shadow-md">
                @error('title')
                <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label for="body" class="block text-gray-700">Description</label>
                <textarea name="body" wire:model="body" id="body"
                          class="block w-full px-4 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md"
                          rows="5"></textarea>
                @error('body')
                <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label for="image" class="block text-gray-700">Image</label>
                <input type="file" wire:model="image" name="image" id="image"
                       class="block w-full px-4 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md shadow-md">
                @error('image')
                <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="px-3 py-2 bg-indigo-500 text-white rounded">Store</button>
        </form>
    </div>
    <div class="max-w-md mx-auto flex flex-col space-y-2">
        @foreach ($posts as $post)
            <div class="flex flex-col items-center bg-white border border-gray-200 rounded-lg shadow md:flex-row md:max-w-xl md:h-auto md:w-48 md:rounded-none md:rounded-l-lg">
                <img class="object-cover w-full rounded-t-lg h-96 md:h-auto md:w-48 md:rounded-none md:rounded-l-lg"
                     src="{{ asset('storage/' . $post->image) }}" alt="">
                <div class="flex flex-col justify-between p-4 leading-normal">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                        {{ $post->title }}
                    </h5>
                    <button wire:click="deletePost({{ $post->id }})" class="px-3 py-2 bg-red-500 text-white rounded">Delete</button>
                </div>
            </div>
        @endforeach
    </div>
</div>
