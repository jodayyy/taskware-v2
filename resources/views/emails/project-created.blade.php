<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Project Created</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
    <div style="background-color: #f8f9fa; padding: 20px; border-radius: 8px; margin-bottom: 20px;">
        <h1 style="color: #2c3e50; margin-top: 0;">New Project Created</h1>
    </div>
    
    <div style="background-color: #ffffff; padding: 20px; border-radius: 8px; border: 1px solid #e0e0e0;">
        <p>Hello,</p>
        
        <p>A new project has been created in Taskware:</p>
        
        <div style="background-color: #f8f9fa; padding: 15px; border-radius: 5px; margin: 20px 0;">
            <h2 style="color: #2c3e50; margin-top: 0;">{{ $project->title }}</h2>
            @if($project->description)
                <p style="color: #666; margin-bottom: 0;">{{ $project->description }}</p>
            @endif
        </div>
        
        <p>You can view the project and manage tasks in your Taskware dashboard.</p>
        
        <p style="margin-top: 30px;">
            <a href="{{ route('projects.show', $project) }}" style="background-color: #007bff; color: #ffffff; padding: 12px 24px; text-decoration: none; border-radius: 5px; display: inline-block;">View Project</a>
        </p>
        
        <p style="margin-top: 30px; color: #666; font-size: 14px;">
            Best regards,<br>
            Taskware Team
        </p>
    </div>
</body>
</html>