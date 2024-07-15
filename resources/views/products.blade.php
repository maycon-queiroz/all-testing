
<ul>
    <li>produto A</li>
    <li>produto B</li>
    @foreach($products as $product)
        <li>{{$product->title}}</li>
    @endforeach
</ul>