/**
 * A simple example to showcase how to chain multiple methods using rxjs
 */
import { from, OperatorFunction, filter, toArray, lastValueFrom } from "rxjs";
interface Asset {
  popular: boolean;
  hot: boolean;
  label: string;
}
const assets: Asset[] = [
  {
    popular: true,
    hot: false,
    label: "a"
  },
  {
    popular: true,
    hot: true,
    label: "b"
  },
  {
    popular: true,
    hot: false,
    label: "c"
  },
  {
    popular: true,
    hot: false,
    label: "d"
  },
  {
    popular: true,
    hot: true,
    label: "e"
  },
  {
    popular: false,
    hot: false,
    label: "f"
  }
];

function isPopular(): OperatorFunction<Asset, Asset> {
  return filter((asset) => asset.popular === true);
}

function isHot(): OperatorFunction<Asset, Asset> {
    return filter((asset) => asset.hot === true);
  }
  
(async () => {
  const a = from(assets).pipe(isPopular(),isHot(), toArray());
  console.log(await lastValueFrom(a));
})();
