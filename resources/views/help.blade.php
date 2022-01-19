<html>
    <header>
        <title>Axie Tracker Report</title>

    </header>
    <body>
        <h1>Help</h1>
        <form action="send_inquiries" method="POST">
            @csrf
            <input type="email" name="email" id="email">
            <input type="text" name="subject" id="subject">
            <textarea name="description" id="description" cols="30" rows="10"></textarea>
            <button type="submit">Send</button>
        </form>
    </body>
</html>