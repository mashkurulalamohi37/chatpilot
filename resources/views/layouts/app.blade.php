<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ChatPilot - WhatsApp SaaS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
      :root {
        --bg-body: #0f172a;
        --bg-card: #1e293b;
        --text-primary: #f8fafc;
        --text-secondary: #94a3b8;
        --accent: #3b82f6;
        --border-color: #334155;
      }
      body { 
        background-color: var(--bg-body); 
        color: var(--text-primary);
        font-family: 'Plus Jakarta Sans', sans-serif;
      }
      .sidebar { 
        min-height: 100vh; 
        background: rgba(30, 41, 59, 0.7); 
        backdrop-filter: blur(10px);
        border-right: 1px solid var(--border-color);
      }
      .sidebar a { 
        color: var(--text-secondary); 
        text-decoration: none; 
        display: block; 
        padding: 12px 15px; 
        border-radius: 8px;
        margin-bottom: 5px;
        transition: all 0.2s;
        font-weight: 500;
      }
      .sidebar a:hover, .sidebar a.active { 
        background-color: rgba(59, 130, 246, 0.1); 
        color: var(--accent);
      }
      
      .card {
        background-color: var(--bg-card);
        border: 1px solid var(--border-color);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        color: var(--text-primary);
      }
      .card-header {
        background-color: rgba(255,255,255,0.02);
        border-bottom: 1px solid var(--border-color);
        color: var(--text-primary);
      }
      .text-muted { color: var(--text-secondary) !important; }
      
      /* Form Elements */
      .form-control, .form-select {
        background-color: #334155;
        border-color: var(--border-color);
        color: white;
      }
      .form-control:focus {
        background-color: #334155;
        color: white;
        border-color: var(--accent);
        box-shadow: 0 0 0 0.25rem rgba(59, 130, 246, 0.25);
      }
      
      /* Tables */
      .table { color: var(--text-primary); --bs-table-bg: transparent; }
      .table thead th { 
        color: var(--text-secondary); 
        border-bottom-color: var(--border-color); 
        background-color: rgba(255,255,255,0.02);
      }
      .table td { border-bottom-color: var(--border-color); }
      
      /* List Group */
      .list-group-item {
        background-color: var(--bg-card);
        border-color: var(--border-color);
        color: var(--text-primary);
      }
      .list-group-item-action:hover, .list-group-item-action:focus {
        background-color: rgba(255, 255, 255, 0.05);
        color: var(--text-primary);
      }
      
      /* Placeholder override */
      ::placeholder { color: #94a3b8 !important; opacity: 1; }
      
      /* Link Colors */
      a { color: var(--accent); }
      a:hover { color: #60a5fa; }
      
      /* Modal */
      .modal-content {
        background-color: var(--bg-card);
        color: var(--text-primary);
        border: 1px solid var(--border-color);
      }
      .modal-header, .modal-footer {
        border-color: var(--border-color);
      }
      .btn-close { filter: invert(1) grayscale(100%) brightness(200%); }
    </style>
  </head>
  <body>
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar p-3" style="width: 250px;">
            <div class="text-center mb-3">
                <img src="{{ asset('images/logo.png') }}" alt="ChatPilot Logo" width="60" height="60" class="rounded-circle mb-2">
                <h4 class="m-0">ChatPilot</h4>
            </div>
            <hr>
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <a href="{{ route('whatsapp.connect') }}">Connect Device</a>
            <a href="{{ route('chat.index') }}">Inbox</a>
            <a href="{{ route('contacts.index') }}">Contacts</a>
            <a href="{{ route('campaigns.index') }}">Campaigns</a>
            <a href="{{ route('ai.config') }}">AI Config</a>
            
            <hr>
            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-link text-white text-decoration-none p-2 w-100 text-start">Logout</button>
            </form>
        </div>

        <!-- Content -->
        <div class="flex-grow-1 p-4">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            Are you sure you want to delete this contact? This action cannot be undone.
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <form id="deleteModalForm" method="POST" action="">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Delete</button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <script>
        var deleteModal = document.getElementById('deleteModal');
        deleteModal.addEventListener('show.bs.modal', function (event) {
          // Button that triggered the modal
          var button = event.relatedTarget;
          // Extract info from data-bs-* attributes
          var action = button.getAttribute('data-action');
          // Update the modal's content.
          var form = deleteModal.querySelector('#deleteModalForm');
          form.action = action;
        });
    </script>
  </body>
</html>
