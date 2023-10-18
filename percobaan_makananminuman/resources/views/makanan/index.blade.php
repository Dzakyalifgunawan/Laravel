<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Data Posts - SantriKoding.com</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
</head>
<body style="background: lightgray">

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div>
                    <h3 class="text-center my-4">Tabel Makanan</h3>         
                    <hr>
                </div>
                <div class="card border-5 shadow-sm rounded">
                    <div class="card-body">
                        <a href="{{ route('makan.create') }}" class="btn btn-md btn-success mb-3">TAMBAH POST</a>
                        <a href="{{ route('minum.index') }}" class="btn btn-md btn-success mb-3">Minuman</a>
                        <a href="{{route('actionlogout')}}" class="btn btn-md btn-success mb-3">Log Out</a>
                        <table class="table table-bordered">
                            <thead>
                              <tr>
                                <th scope="col">GAMBAR</th>
                                <th scope="col">NAMA</th>
                                <th scope="col">HARGA</th>
                                <th scope="col">AKSI</th>
                              </tr>
                            </thead>
                            <tbody>
                              @forelse ($makanan as $makan)
                                <tr>
                                    <td class="text-center">
                                        <img src="{{ asset('/storage/posts/'.$makan->image) }}" class="rounded" style="width: 150px">
                                    </td>
                                    <td>{{ $makan->nama }}</td>
                                    <!-- Convert ke Rupiah -->
                                    <td>{{ 'Rp ' . number_format($makan->harga, 0, ',', '.') }}</td>
                                    <td class="text-center">
                                        <form onsubmit="return confirm('Apakah Anda Yakin ?');" action="{{ route('makan.destroy', $makan->id) }}" method="POST">
                                            <a href="{{ route('makan.show', $makan->id) }}" class="btn btn-sm btn-dark">SHOW</a>
                                            <a href="{{ route('makan.edit', $makan->id) }}" class="btn btn-sm btn-primary">EDIT</a>
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">HAPUS</button>
                                        </form>
                                    </td>
                                </tr>
                              @empty
                                  <div class="alert alert-danger">
                                      Data Makanan belum Tersedia.
                                  </div>
                              @endforelse
                            </tbody>
                          </table>  
                          {{ $makanan->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        //message with toastr
        if(session()-has('success'))
        
            toastr.success('{{ session(',success,') }}', 'BERHASIL!'); 

        elseif(session()-has('error'))

            toastr.error('{{ session(',error,') }}', 'GAGAL!'); 
            
        endif
    </script>

</body>
</html>