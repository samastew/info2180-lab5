document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('lookup').addEventListener('click', function() {
        const country = document.getElementById('country').value;
        const xhr = new XMLHttpRequest();
        
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                document.getElementById('result').innerHTML = xhr.responseText;
            }
        };
        
        xhr.open('GET', `world.php?country=${encodeURIComponent(country)}`, true);
        xhr.send();
    });
});