import re
import sys

def process_file(filepath):
    with open(filepath, 'r') as f:
        content = f.read()

    # Form groups
    content = content.replace('<div class="form-group">', '<div class="form-group lp-form-group">')
    
    # Inputs & Selects
    content = content.replace('class="form-control"', 'class="form-control lp-input"')
    content = content.replace('class="form-control date1"', 'class="form-control lp-input date1"')
    content = content.replace('class="form-control select2"', 'class="form-control lp-input select2"')
    content = content.replace('class="form-control "', 'class="form-control lp-input "')
    
    # Buttons
    content = content.replace('class="btn btn-danger"', 'class="btn btn-danger lp-btn lp-btn-danger"')
    content = content.replace('class="btn btn-success"', 'class="btn btn-success lp-btn lp-btn-primary"')

    with open(filepath, 'w') as f:
        f.write(content)

process_file('resources/views/admin/invoice/modal_invoice_paid.blade.php')

def process_history(filepath):
    with open(filepath, 'r') as f:
        content = f.read()
    content = content.replace('<table class="table">', '<table class="table lp-table">')
    with open(filepath, 'w') as f:
        f.write(content)

process_history('resources/views/admin/invoice/payment-history.blade.php')

