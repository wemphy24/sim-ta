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
    <h3 class="title_">Detail Material</h3>

    <table>
        @foreach ($namaBarang as $nb)
        <tr>
            <td><span style="font-weight: bold">{{ $nb->set_good['name'] }}</span></td>
        </tr>
        @endforeach
    </table>

    <table class="border_">
        <tr>
            <th class="border_">No</th>
            <th class="border_">Nama</th>
            <th class="border_">Satuan</th>
            <th class="border_">Qty</th>
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

