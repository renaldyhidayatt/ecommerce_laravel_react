import { useEffect } from 'react';
import { useSelector, useDispatch } from 'react-redux';
import { useParams } from 'react-router-dom';
import { fetchCategoryBySlug } from '../redux/category';

export default function CategoryPage() {
  const { slug } = useParams();
  const category = useSelector((state) => state.category.category);
  const loading = useSelector((state) => state.category.loading);
  const error = useSelector((state) => state.category.error);
  const dispatch = useDispatch();

  useEffect(() => {
    dispatch(fetchCategoryBySlug(slug));
  }, [dispatch, slug]);

  return (
    <div className="max-w-screen-xl mx-auto mt-10">
      {!loading && error && (
        <h1 className="text-2xl font-semibold p-3">Error: {error}</h1>
      )}
      {!loading && !error && !category && (
        <h1 className="text-2xl font-semibold p-3">No category found</h1>
      )}
      {!loading && !error && category && category.products && (
        <>
          <h1 className="text-2xl font-semibold p-3">
            {category.nama_kategori}
          </h1>
          <div className="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
            {category.products.map((product) => (
              <a
                href={`/product/detail/${product.slug_product}`}
                key={product.product_id}
                className="sm:col-span-1 md:col-span-1 lg:col-span-1"
              >
                <div className="p-4 border rounded-lg shadow-md bg-white">
                  <div className="relative overflow-hidden">
                    <img
                      src={`http://localhost:5000/${product.image_product}`}
                      className="w-full h-40 object-cover rounded-lg"
                      alt={product.name}
                    />
                  </div>
                  <div className="mt-4">
                    <h3 className="text-lg font-semibold text-gray-800">
                      {product.name}
                    </h3>
                    <p className="mt-1 text-gray-600">{product.description}</p>
                    <p className="mt-2 text-gray-800 font-semibold">
                      Rp. {product.price}
                    </p>
                  </div>
                </div>
              </a>
            ))}
          </div>
        </>
      )}
      {loading && <h1>Loading...</h1>}
    </div>
  );
}
