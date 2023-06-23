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
  <h3 class="title_">Penawaran</h3>

  {{-- DATA CUSTOMER --}}
  <table>
    @foreach ($dataPenawaran as $pn)
    <tr>
      <td>Kepada : <span style="font-weight: bold">{{ $pn->customer['name'] }}</span></td>
      <td>Kode Penawaran : <span style="font-weight: bold">{{ $pn->quotation_code }}</span></td>
    </tr>
    <tr>
      <td>Alamat : <span style="font-weight: bold">{{ $pn->location }}</span></td>
      <td>Subjek Penawaran : <span style="font-weight: bold">{{ $pn->name }}</span></td>
    </tr>
    <tr>
      <td>Telepon : <span style="font-weight: bold">{{ $pn->customer['phone'] }}</span></td>
      <td>Tanggal : <span style="font-weight: bold">24 January 2024</span></td>
    </tr>
    @endforeach
  </table>

  {{-- DATA BARANG --}}
  <table class="border_">
    <tr>
      <th class="border_">No</th>
      <th class="border_">Kode Item</th>
      <th class="border_">Nama</th>
      <th class="border_">Qty</th>
      <th class="border_">Satuan</th>
      <th class="border_">Harga Satuan</th>
      <th class="border_">Total Harga</th>
    </tr>
    @foreach ($dataBarang as $bg)
    <tr>
        <td class="center_ border_">{{ $loop->index + 1 }}</td>
        <td class="border_">{{ $bg->set_good['set_goods_code'] }}</td>
        <td class="border_">{{ $bg->set_good['name'] }}</td>
        <td class="center_ border_">{{ $bg->qty }}</td>
        <td class="center_ border_">{{ $bg->set_good->measurement['name'] }}</td>
        <td class="right_ border_">Rp.{{ number_format($bg->set_good['price']) }}</td>
        <td class="right_ border_">Rp. {{ number_format($bg->price) }}</td>
    </tr>
    @endforeach
    @foreach ($dataBiaya as $ba)
    <tr>
        <td colspan="5" style="border: none"> </td>
            <td style="font-weight: bold" class="border_">GRAND TOTAL</td>
            <td style="font-weight: bold" class="right_ border_">Rp. {{ number_format($ba->total_price) }}</td>    
        </tr>
    @endforeach
  </table>
</div>