<div>
    <div>
      <button wire:click="loadTable" class="btn btn-primary">Load Category 1</button>
      <button wire:click="loadTable" class="btn btn-secondary">Load Category 2</button>
    </div>

    @if($showTable)
      <table class="table">
        <thead>
          <tr>
            <th>Name</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>{{ $name }}</td>
          </tr>
        </tbody>
      </table>
    @endif
</div>
