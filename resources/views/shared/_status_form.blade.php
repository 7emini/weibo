<form action="{{ route('statuses.store') }}" method="post">
    {{ csrf_field() }}
    <textarea name="content" rows="5" class="form-control" placeholder="聊聊新鲜事">{{ old('content') }}</textarea>
    <div class=" text-right">
        <button type="submit" class="btn btn-primary mt-3">发布</button>
    </div>
</form>