<style>
  @page {
  size: A4 landscape;
  }
  .body_ {
  font-family: "Lucida Console", "Courier New", monospace;
  }
  p {
  margin: 0.5rem 0;
  }
  .title_ {
  text-align: center;
  }
  .border_ {
  border: 1px solid;
  }
  table {
  margin: 1rem 0;
  width: 100%;
  border-collapse: collapse;
  }
  th {
  padding: 0.5rem 0;
  background-color: grey;
  }
  .center_ {
  text-align: center;
  }
  .right_ {
  text-align: right;
  }
</style>

<div class="body_">
  <table style="text-align: center">
    <tr>
      <td><h3>Panel Maker & Electrical Engineering</h3></td>
    </tr>
    <tr>
      <td>Jl. Imam Bonjol 332, Badung Bali</td>
    </tr>
    <tr>
      <td>Telp. 0361 8989 7632</td>
    </tr>
    <tr>
      <td>Email. naradaofficial@gmail.com</td>
    </tr>
  </table>
  <hr
    style="
      width: 80%;
      height: 2px;
      border-width: 0;
      color: gray;
      background-color: gray;
    "
  />
  <h2 class="title_">Penawaran</h2>

  {{-- DATA PENAWARAN CUSTOMER --}}
  <table>
    @foreach ($dataPenawaran as $dp)
    <tr>
      <td>Kepada : <span style="font-weight: bold">{{ $dp->customer['name'] }}</span></td>
      <td>Kode Penawaran : <span style="font-weight: bold">{{ $dp->quotation_code }}</span></td>
    </tr>
    <tr>
      <td>Alamat : <span style="font-weight: bold">{{ $dp->location }}</span></td>
      <td>Subjek Penawaran : <span style="font-weight: bold">{{ $dp->name }}</span></td>
    </tr>
    <tr>
      <td>Telepon : <span style="font-weight: bold">{{ $dp->customer['phone'] }}</span></td>
      <td>Tanggal : <span style="font-weight: bold">{{ $dp->date }}</span></td>
    </tr>
    @endforeach
  </table>

  {{-- DATA BARANG --}}
  <table class="border_">
    <tr>
      <th style="background-color: #27272a; color: white" class="border_">No</th>
      <th style="background-color: #27272a; color: white" class="border_">Kode Item</th>
      <th style="background-color: #27272a; color: white" class="border_">Nama</th>
      <th style="background-color: #27272a; color: white" class="border_">Qty</th>
      <th style="background-color: #27272a; color: white" class="border_">Satuan</th>
      <th style="background-color: #27272a; color: white" class="border_">Harga Satuan</th>
      <th style="background-color: #27272a; color: white" class="border_">Total Harga</th>
    </tr>
    @foreach ($dataBarang as $db)
    <tr>
        <td class="center_ border_">{{ $loop->index + 1 }}</td>
        <td class="border_">{{ $db->good['good_code'] }}</td>
        <td class="border_">{{ $db->good['name'] }}</td>
        <td class="center_ border_">{{ $db->qty }}</td>
        <td class="center_ border_">{{ $db->good->measurement['name'] }}</td>
        <td class="right_ border_">Rp.{{ number_format($db->price) }}</td>
        <td class="right_ border_">Rp. {{ number_format($db->total_price) }}</td>
    </tr>
    @endforeach
    @foreach ($dataRabpValue as $drv)
    <tr>
        <td colspan="5" style="border: none"> </td>
        <td style="font-weight: bold" class="border_">DISKON {{ $drv->discount }} %</td>
        <td style="font-weight: bold" class="right_ border_">- Rp. {{ number_format($jumlahDiskon) }}</td>    
    </tr>
    <tr>
        <td colspan="5" style="border: none"> </td>
        <td style="font-weight: bold" class="border_">PPN 11 %</td>
        <td style="font-weight: bold" class="right_ border_">Rp. {{ number_format($jumlahPPN) }}</td>    
    </tr>
    <tr>
        <td colspan="5" style="border: none"> </td>
        <td style="font-weight: bold" class="border_">GRAND TOTAL</td>
        <td style="font-weight: bold" class="right_ border_">Rp. {{ number_format($drv->rabp_value) }}</td>    
    </tr>
    @endforeach
  </table>
</div>