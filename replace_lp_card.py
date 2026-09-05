import os

files = [
    '/home/ammar/code/lawprosystem/resources/views/admin/role/index.blade.php',
    '/home/ammar/code/lawprosystem/resources/views/admin/auth/passwords/reset.blade.php',
    '/home/ammar/code/lawprosystem/resources/views/admin/auth/passwords/email.blade.php',
    '/home/ammar/code/lawprosystem/resources/views/admin/vendor/vendor.blade.php',
    '/home/ammar/code/lawprosystem/resources/views/admin/auth/login.blade.php',
    '/home/ammar/code/lawprosystem/resources/views/admin/service/service.blade.php',
    '/home/ammar/code/lawprosystem/resources/views/admin/client/client_edit.blade.php',
    '/home/ammar/code/lawprosystem/resources/views/admin/recent-activity/recent_activity.blade.php',
    '/home/ammar/code/lawprosystem/resources/views/admin/client/client.blade.php',
    '/home/ammar/code/lawprosystem/resources/views/admin/client/client_create.blade.php',
    '/home/ammar/code/lawprosystem/resources/views/admin/client/view/client_detail.blade.php',
    '/home/ammar/code/lawprosystem/resources/views/admin/client/view/cases_view.blade.php',
    '/home/ammar/code/lawprosystem/resources/views/admin/client/view/client_account.blade.php'
]

for filepath in files:
    with open(filepath, 'r') as f:
        content = f.read()
    
    # We want to replace class="x_panel lp-card" with class="x_panel lp-panel"
    # Or class="lp-card" with class="lp-panel"
    # But carefully avoiding replacing lp-card inside some other text, just standard replacements
    
    content = content.replace('class="x_panel lp-card"', 'class="x_panel lp-panel"')
    content = content.replace('class="lp-card"', 'class="lp-panel"')
    
    with open(filepath, 'w') as f:
        f.write(content)

print(f"Replaced lp-card with lp-panel in {len(files)} files.")
