<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Performance Profile</title>
    <style>
        /* Your styles here */
    </style>
</head>
<body>
    <h1>Performance Profiles</h1>
    <ul>
        @foreach($performanceProfiles as $profile)
            <li>ID: {{ $profile->id }} - Name: {{ $profile->name }}</li>
            <!-- Add more details from the profile as needed -->
        @endforeach
    </ul>
</body>
</html>
