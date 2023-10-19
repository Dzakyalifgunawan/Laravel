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
                    <h3 class="text-center my-4">Tabel bahan</h3>         
                    <hr>
                </div>
                <div class="card border-5 shadow-sm rounded">
                    <div class="card-body">
                        <a href="{{ route('bahan.create') }}" class="btn btn-md btn-success mb-3">TAMBAH POST</a>
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
                              @forelse ($bahan as $bahans)
                                <tr>
                                    <td class="text-center">
                                        <img src="{{ asset('/storage/posts/'.$bahans->image) }}" class="rounded" style="width: 150px">
                                    </td>
                                    <td>{{ $bahans->nama }}</td>
                                    <!-- Convert ke Rupiah -->
                                    <td>{{ 'Rp ' . number_format($bahans->harga, 0, ',', '.') }}</td>
                                    <td class="text-center">
                                        <form onsubmit="return confirm('Apakah Anda Yakin ?');" action="{{ route('bahan.destroy', $bahans->id) }}" method="POST">
                                            <a href="{{ route('bahan.show', $bahans->id) }}" class="btn btn-sm btn-dark">SHOW</a>
                                            <a href="{{ route('bahan.edit', $bahans->id) }}" class="btn btn-sm btn-primary">EDIT</a>
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">HAPUS</button>
                                        </form>
                                    </td>
                                </tr>
                              @empty
                                  <div class="alert alert-danger">
                                      Data bahan belum Tersedia.
                                  </div>
                              @endforelse
                            </tbody>
                          </table>  
                          {{ $bahan->links() }}
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