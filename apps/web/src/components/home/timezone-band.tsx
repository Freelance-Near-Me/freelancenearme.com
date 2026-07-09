"use client";

import { useEffect, useMemo, useState } from "react";

const TIMEZONE = "America/New_York";
const CITY_LABEL = "New York";
const LOCALE = "en-US";

export function TimezoneBand() {
  const [now, setNow] = useState(() => new Date());

  useEffect(() => {
    const timer = setInterval(() => setNow(new Date()), 30_000);
    return () => clearInterval(timer);
  }, []);

  const fmt = useMemo(
    () =>
      new Intl.DateTimeFormat(LOCALE, {
        timeZone: TIMEZONE,
        hour12: false,
        hour: "2-digit",
        minute: "2-digit",
      }),
    []
  );

  const tzAbbrev = useMemo(() => {
    const parts = new Intl.DateTimeFormat(LOCALE, {
      timeZone: TIMEZONE,
      timeZoneName: "short",
    }).formatToParts(now);
    return parts.find((p) => p.type === "timeZoneName")?.value ?? "ET";
  }, [now]);

  const timeStr = fmt.format(now);
  const localHour = parseInt(timeStr.slice(0, 2), 10);

  return (
    <div className="shadow-soft rounded-2xl border border-bone-200 bg-white p-5 md:p-6">
      <div className="mb-4 flex flex-wrap items-end justify-between gap-3">
        <div>
          <p className="eyebrow mb-1">US time, right now</p>
          <p className="font-serif text-[26px] leading-none font-semibold text-ink-900 md:text-[30px]">
            {CITY_LABEL} {timeStr}{" "}
            <span className="font-display-italic text-[20px] font-normal text-ink-500">
              {tzAbbrev}
            </span>
          </p>
        </div>
        <div className="flex items-center gap-4 text-[12.5px] text-ink-500">
          <span className="inline-flex items-center gap-1.5">
            <span className="h-2.5 w-3.5 rounded-sm bg-ink-900/20" /> Working hours
          </span>
          <span className="inline-flex items-center gap-1.5">
            <span className="h-2.5 w-3.5 rounded-sm bg-ochre-500" /> Right now
          </span>
        </div>
      </div>

      <div className="tz-band">
        {Array.from({ length: 24 }).map((_, h) => {
          const isBusiness = h >= 8 && h < 18;
          const isNow = h === localHour;
          return (
            <div
              key={h}
              className={`tz-cell ${isBusiness ? "business" : ""} ${isNow ? "now" : ""}`}
              title={`${String(h).padStart(2, "0")}:00 ${CITY_LABEL}`}
            />
          );
        })}
      </div>

      <div className="mt-2 grid grid-cols-12 font-mono text-[10.5px] tracking-tight text-ink-500/70">
        <span className="col-span-3">00</span>
        <span className="col-span-3 text-center">06</span>
        <span className="col-span-3 text-center">12</span>
        <span className="col-span-3 text-right">24</span>
      </div>

      <p className="mt-4 text-[13px] leading-relaxed text-ink-700">
        Every freelancer here works{" "}
        <span className="font-semibold text-ink-900">ET-friendly hours</span>. No 3 a.m.
        Slack replies waiting on Manila or Manhattan, no overnight blockers.
      </p>
    </div>
  );
}
