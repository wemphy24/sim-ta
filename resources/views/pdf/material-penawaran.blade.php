<style>
  @page {
    size: A4 landscape;
  }
  .body_ {
    font-family: "Lucida Console", "Courier New", monospace;
  }
  .title_ {
  text-align: center;
  }
  th {
  padding: 0.5rem 0;
  background-color: grey;
  }
  .border_ {
    border: 1px solid;
  }
  table {
    margin: 1rem 0;
    width: 100%;
    border-collapse: collapse;
  }
  .center_ {
    text-align: center;
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
  <h2 class="title_">Detail Material</h2>

    <table>
        @foreach ($namaBarang as $nb)
        <tr>
            <td><span style="font-weight: bold">{{ $nb->set_good['name'] }}</span></td>
        </tr>
        @endforeach
    </table>

    <table class="border_">
        <tr>
            <th style="background-color: #27272a; color: white" class="border_">No</th>
            <th style="background-color: #27272a; color: white" class="border_">Nama</th>
            <th style="background-color: #27272a; color: white" class="border_">Satuan</th>
            <th style="background-color: #27272a; color: white" class="border_">Qty</th>
        </tr>
        @foreach ($dataMaterial as $dm)
        <tr>
            <td class="border_ center_">{{ $loop->index + 1 }}</td>
            <td class="border_">{{ $dm->material['name'] }}</td>
            <td class="border_ center_">{{ $dm->material->measurement['name'] }}</td>
            <td class="border_ center_">{{ $dm->qty }}</td>
        </tr>
        @endforeach
    </table>
</div>

