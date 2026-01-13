@extends('layouts.admin')

@section('content')
<style>
   form{
    display: flex;
    flex-direction: column;
    gap: 10px;
    background-color: white;
    padding: 20px;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    border: 1px solid gray;
   }
   input, textarea{
    padding: 5px;
    border: 1px solid #ccc;
    border-radius: 4px;
   }
    button{
    padding: 7px;
    background-color: #4CAF50;
    color: white;
    border: none;
    border-radius: 4px;
    margin-bottom: 5px;
    }

    #productForm {
      display: none;
    }

    #productForm.active{
      display: flex;
    }
</style>

<div class="flex flex-col gap-5 max-w-500">

    <form id="productForm" enctype="multipart/form-data">
        @csrf
        <label>Product name</label>
        <input type="text" name="productName" required>

        <label>Product price</label>
        <input type="number" step="0.01" name="productPrice" required>

        <label>Select Categories:</label>
<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 5px; margin-bottom: 10px;">
    @foreach($categories as $category)
        <div style="display: flex; align-items: center; gap: 8px;">
            <input type="checkbox" 
                   name="categories[]" 
                   value="{{ $category->id }}" 
                   id="cat_{{ $category->id }}">
            <label style="margin-top: 0;" for="cat_{{ $category->id }}">
                {{ $category->label }}
            </label>
        </div>
    @endforeach
</div>

        <label>Product description</label>
        <textarea name="productDescription" required></textarea>

        <label>Product img</label>
        <input type="file" name="productImage">

        <button type="submit">Create Product</button>
    </form>


    <div class="max-w-500">
            <div class="flex  justify-between mb-3">
                <button id="btnopen">Add product</button>
                <input type="text" id="searchInput" placeholder="Search products..." class="form-control ">
            </div>
        <table border="1" style="width: 100%;">
            <thead class="p-1 border border-gray-300">
                <tr>
                    <th class="p-1 border border-gray-300">Name</th>    
                    <th class="p-1 border border-gray-300">Price</th>
                    <th class="p-1 border border-gray-300">Categories</th>
                    <th class="p-1 border border-gray-300">Description</th>
                </tr>
            </thead>
            <tbody id="productBody">
                @foreach($products as $product)
                    @include('admin.products.partials.row', compact('product'))
                @endforeach
            </tbody>
        </table>
    </div>

</div>

<script>
  const form = document.getElementById('productForm');
  const btnOpen = document.getElementById('btnopen');

  btnOpen.addEventListener('click', ()=>{
    form.classList.toggle('active');
  })

  
    document.getElementById('productForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        const form = e.target;
        const formData = new FormData(form);

        try {
            const response = await fetch("{{ route('products.store') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'text/html' 
                },
                body: formData
            });

            if (response.ok) {
                const htmlRow = await response.text();
                document.getElementById('productBody').insertAdjacentHTML('beforeend', htmlRow);
                alert('Product created successfully!');
                form.reset();
            } else {
                alert('Error: ' + ( 'Check console for details'));
            }
        } catch (error) {
            console.error('Fetch error:', error);
        }
    });



    let debounceTimer;

    document.getElementById('searchInput').addEventListener('input', (e) => {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(async () => {
            const response = await fetch(`{{ route('admin.products.index') }}?search=${e.target.value}`);
            const html = await response.text();
            
            // Extract only the product rows from the full page HTML
            const doc = new DOMParser().parseFromString(html, 'text/html');
            const newRows = doc.getElementById('productBody').innerHTML;
            
            document.getElementById('productBody').innerHTML = newRows;
        }, 300);
    });
</script>
@endsection