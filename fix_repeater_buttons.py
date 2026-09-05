import re

files = [
    'resources/views/admin/client/client_create.blade.php',
    'resources/views/admin/client/client_edit.blade.php'
]

for filepath in files:
    with open(filepath, 'r') as f:
        content = f.read()
    
    # Fix the Add New button to include text
    # Original: <button data-repeater-create type="button" value="{{ __('frontend.client.add_new') }}" class="btn btn-success lp-btn lp-btn-primary waves-effect waves-light btn btn-success-edit" type="button"><i class="fa fa-plus" aria-hidden="true"></i></button>
    
    # We'll use regex to inject the text inside the button tag
    content = re.sub(
        r'(<button data-repeater-create[^>]*>)\s*(<i class="fa fa-plus"[^>]*></i>)\s*(</button>)',
        r'\1\2 {{ __(\'frontend.client.add_new\') }}\3',
        content
    )
    # Some buttons might have value="Add New"
    content = re.sub(
        r'(<button data-repeater-create[^>]*>)\s*(<i class="fa fa-plus"[^>]*></i>)\s*(</button>)',
        r'\1\2 Add New\3', # fallback
        content
    )

    with open(filepath, 'w') as f:
        f.write(content)
