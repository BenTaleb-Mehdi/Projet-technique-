## Prompt Upadate ProductServiceTest
```
Update this Laravel ProductServiceTest to stop creating new products and categories using factories or create() methods. Instead, fetch existing data from the database (which has been seeded via CSV). Ensure that:

test_it_can_filter_products_by_name picks a product name that actually exists in the DB.

test_it_can_filter_products_by_category fetches an existing category and a product associated with it.

test_it_can_update_a_product fetches the first available product and updates its name.

Keep using DatabaseTransactions to ensure no changes persist after tests.

```