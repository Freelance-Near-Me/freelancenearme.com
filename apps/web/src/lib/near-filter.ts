import { distanceMiles, geocodeLocation } from "@/lib/geocode";

type Located = {
  city?: string | null;
  postcode?: string | null;
  latitude?: number | null;
  longitude?: number | null;
};

function sameCode(a: string, b: string) {
  return a.toLowerCase().replace(/\s+/g, "") === b.toLowerCase().replace(/\s+/g, "");
}

/**
 * Filter rows by a US ZIP code, UK postcode, or city name.
 * A radius uses coordinates. Without a radius, match the city or ZIP text.
 */
export async function applyNearFilter<T extends Located>(
  rows: T[],
  near: string | undefined,
  radiusMiles: number | undefined
): Promise<Array<T & { distanceMiles?: number }>> {
  const query = near?.trim();
  if (!query) {
    return rows.map((row) => ({ ...row, distanceMiles: undefined }));
  }

  if (radiusMiles && radiusMiles > 0) {
    const origin = await geocodeLocation({ postcode: query, country: "United States" });
    if (origin) {
      return rows
        .filter((row) => row.latitude != null && row.longitude != null)
        .map((row) => ({
          ...row,
          distanceMiles: distanceMiles(
            { latitude: origin.latitude, longitude: origin.longitude },
            { latitude: row.latitude!, longitude: row.longitude! }
          ),
        }))
        .filter((row) => row.distanceMiles <= radiusMiles)
        .sort((a, b) => a.distanceMiles - b.distanceMiles);
    }
  }

  const needle = query.toLowerCase();
  return rows
    .filter((row) => {
      const city = row.city?.toLowerCase() ?? "";
      const code = row.postcode ?? "";
      return city.includes(needle) || (code.length > 0 && sameCode(code, query));
    })
    .map((row) => ({ ...row, distanceMiles: undefined }));
}
