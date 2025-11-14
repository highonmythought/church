@props([
    'id',             // modal ID, e.g. 'addPastorModal'
    'title',          // modal title, e.g. 'Add Pastor'
    'action',         // form action route
    'fields' => [],   // array of fields: [['name'=>'field_name','type'=>'text','label'=>'Label']]
    'enctype' => null // for file uploads
])

<div class="modal fade" id="{{ $id }}" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form id="{{ $id }}Form"
          method="POST"
          action="{{ $action }}"
          {{ $enctype ? 'enctype='.$enctype : '' }}>
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">{{ $title }}</h5>
          <button class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          @foreach($fields as $field)
              @php
                  $name = $field['name'];
                  $type = $field['type'] ?? 'text';
                  $label = $field['label'] ?? ucfirst(str_replace('_',' ',$name));
              @endphp
              <div class="mb-2">
                  <label class="form-label">{{ $label }}</label>
                  @if($type === 'textarea')
                      <textarea name="{{ $name }}" class="form-control"></textarea>
                  @elseif($type === 'select')
                      <select name="{{ $name }}" class="form-control">
                          <option value="">Select {{ $label }}</option>
                          @foreach($field['options'] ?? [] as $key => $value)
                              <option value="{{ $key }}">{{ $value }}</option>
                          @endforeach
                      </select>
                  @else
                      <input type="{{ $type }}" name="{{ $name }}" class="form-control">
                  @endif
              </div>
          @endforeach
        </div>

        <div class="modal-footer">
          <button class="btn btn-success" type="submit">Save</button>
          <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </form>
  </div>
</div>

<script>
document.getElementById('{{ $id }}Form').addEventListener('submit', async e => {
    e.preventDefault();
    const res = await fetch(e.target.action, {
        method: 'POST',
        headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
        body: new FormData(e.target)
    });
    if(res.ok) location.reload();
});
</script>
