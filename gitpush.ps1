# Prompt for user credentials
$githubUsername = "QaziTalha4595"
$githubPassword = ConvertTo-SecureString -String "Talha@4595#" -AsPlainText -Force

# Set the path to the folder where changes need to be pushed
$folderPath = "C:\xampp\htdocs\alshahab"

# Navigate to the folder
Set-Location $folderPath

# Initialize a new Git repository (if not already initialized)
if (-not (Test-Path -Path "$folderPath\.git")) {
    git init
}

# Add all files in the folder to the staging area
git add .

# Commit the changes
$commitMessage = get-date
git commit -m $commitMessage

# Push the changes to GitHub
$githubCred = New-Object System.Management.Automation.PSCredential($githubUsername, $githubPassword)
git push -u origin master -Credential $githubCred
