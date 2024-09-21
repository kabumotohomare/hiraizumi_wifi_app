<script>
    document.getElementById('postal_code').addEventListener('input', function() {
        const postalCode = this.value;
        if (postalCode.length === 7) {
            // Call API when postal code is 7 digits
            fetch(`https://zipcloud.ibsnet.co.jp/api/search?zipcode=${postalCode}`)
                .then(response => response.json())
                .then(data => {
                    if (data.status === 200 && data.results) {
                        const address = data.results[0];
                        document.getElementById('address').value = address.address1 + address.address2 + address.address3;
                    } else {
                        alert('Address not found');
                    }
                })
                .catch(error => console.error('Error fetching postal code:', error));
        }
    });
</script>
