/**
 * Caracteres Unicode pour la typographie francaise.
 * Constantes nommees avec echappements explicites (\uXXXX) pour eviter
 * toute ambiguite avec des espaces normales (invisibles et fragiles).
 * @see https://unicode.org/charts/
 */
export const UNICODE_CHARS = {
	// ========================
	// ESPACES SPECIAUX
	// ========================

	/** Espace fine insecable (U+202F) - avant ; ! ? et dans les guillemets */
	NO_BREAK_THIN_SPACE: "\u202F",
	/** Espace insecable (U+00A0) - avant : en francais */
	NO_BREAK_SPACE: "\u00A0",

	// ========================
	// GUILLEMETS
	// ========================

	/** Guillemet francais ouvrant (U+00AB) */
	LAQUO: "\u00AB",
	/** Guillemet francais fermant (U+00BB) */
	RAQUO: "\u00BB",
	/** Guillemet anglais ouvrant (U+201C) */
	LDQUO: "\u201C",
	/** Guillemet anglais fermant (U+201D) */
	RDQUO: "\u201D",
};
