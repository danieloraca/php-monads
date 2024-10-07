import Data.Maybe (fromMaybe)

-- Function to divide two numbers, returning Maybe Double
divide :: Double -> Double -> Maybe Double
divide _ 0 = Nothing  -- Division by zero results in Nothing (error)
divide numerator denominator = Just (numerator / denominator) -- Success case

-- A function to double the result
double :: Double -> Double
double x = x * 2

main :: IO ()
main = do
    -- Example 1: Division success case
    let result1 = divide 10 2 >>= (return . double) -- Using monadic bind (>>=) to chain
    putStrLn $ "Result 1: " ++ show (fromMaybe 0 result1) -- Print result or fallback to 0

    -- Example 2: Division by zero (error case)
    let result2 = divide 10 0 >>= (return . double) -- Won't run double, because divide returns Nothing
    putStrLn $ "Result 2: " ++ show (fromMaybe 0 result2) -- Fallback to 0 on error
