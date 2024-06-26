function toggleFilter(filterId) {
    const filterElement = document.getElementById(filterId);
    filterElement.classList.toggle('hidden');
}

document.querySelectorAll('.filter-checkbox').forEach(checkbox => {
    checkbox.addEventListener('change', () => {
        const filters = {};
        document.querySelectorAll('.filter-checkbox:checked').forEach(checked => {
            if (!filters[checked.name]) {
                filters[checked.name] = [];
            }
            filters[checked.name].push(checked.value);
        });

        fetch('/api/filter-products.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(filters)
        })
        .then(response => {
            console.log('Response status:', response.status);
            return response.text().then(text => {
                console.log('Response text:', text);
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return JSON.parse(text);
            });
        })
        .then(data => {
            if (data.error) {
                throw new Error(data.error);
            }

            const productList = document.getElementById('product-list');
            productList.innerHTML = '';
            data.products.forEach(product => {
                const productElement = document.createElement('div');
                productElement.classList.add('border', 'p-4', 'rounded', 'shadow');

                const productLink = document.createElement('a');
                productLink.href = `/pages/details-product.php?product_id=${product.product_id}`;

                const productTitleLink = document.createElement('a');
                productTitleLink.href = `/pages/details-product.php?product_id=${product.product_id}`;
                productTitleLink.classList.add('text-xl', 'font-semibold');
                productTitleLink.textContent = product.product_name;

                const productPrice = document.createElement('p');
                productPrice.classList.add('text-green-500', 'font-bold');
                productPrice.textContent = `Prix : ${product.price} €`;

                const productWeight = document.createElement('p');
                productWeight.classList.add('text-gray-500');
                productWeight.textContent = `Poids : ${product.quantity_weight}`;

                productElement.appendChild(productTitleLink);
                productElement.appendChild(productPrice);
                productElement.appendChild(productWeight);

                productList.appendChild(productElement);
            });
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
});
