<div>
    <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4">
        <x-admin.components.stat-card
            label="Total Users"
            value="{{ $totalUsers }}" 
            icon="users"
            color="orange" />

            <x-admin.components.stat-card
            label="Total Categories"
            value="{{ $totalCategories }}" 
            icon="collection"
            color="green" />

            <x-admin.components.stat-card
            label="Total Products"
            value="{{ $totalProducts }}" 
            icon="cube"
            color="red" />

            <x-admin.components.stat-card
            label="Total Blogs"
            value="{{ $totalBlogs }}" 
            icon="book-open"
            color="purple" />
    </div>
</div>
