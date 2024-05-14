<x-mail::message>
# {{ $create }}  فاتورة انشاءت بواسطة 

The body of your message.

<x-mail::button :url="'http://127.0.0.1:8000/invoice_details/'">
    عرض الفاتورة
</x-mail::button>
Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
