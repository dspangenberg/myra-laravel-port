<x-layout :styles="$styles">
  <h2>Leistungsnachweis</h2>
  <p>
    {{ $times['stats']['startOfWeek']->format("d.m.Y") }} -  {{ $times['stats']['endOfWeek']->format("d.m.Y") }}
  </p>


  @foreach ($times['groupedByDay'] as $entries)
    <strong>{{ $entries['date'] }}</strong>
    @foreach ($entries['entries'] as $entry)
      <table>
        <tr>
          <td>
            {{ $entry['begin_at']->format("H:i") }} - {{ $entry['end_at']->format("H:i") }}
          </td>
        </tr>
      </table>
    @endforeach
  @endforeach


  <htmlpagefooter name="footer">
    <table width="100%">
      <tr>
        <td width="50%">&nbsp;</td>
        <td width="50%" style="text-align: right;">{PAGENO}/{nbpg}</td>
      </tr>
    </table>
  </htmlpagefooter>'

</x-layout>
